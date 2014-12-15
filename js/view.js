(function(){

      var teller = 0;
        
      function init(){

          for(var i = 0; i < items.length; i++){
             var sticky = new Sticky(
             items[i].color,
             items[i].contentlink,
             items[i].datum,
             items[i].description,
             items[i].extension,
             items[i].id,
             items[i].posX,
             items[i].posY,
             items[i].project_id,
             items[i].title,
             items[i].user_id,
             itemCreators[i][0]['email']
             );
             document.body.appendChild(sticky.el);
          }


      }

      function Sticky(color, contentlink, datum, description, extension, id, posX, posY, project_id, title, user_id, user) {
           
        //aanmaken HTML-element
        this.el = document.createElement('div');

        var deleteEl = document.createElement("a");   
        deleteEl.classList.add('stickyDeleteButton');
        deleteEl.setAttribute('href',"index.php?page=deleteItem&id=" + id);  
        deleteEl.setAttribute('itemId', id);   
        var t = document.createTextNode("x");       
        deleteEl.appendChild(t);                     
        this.el.appendChild(deleteEl);  

        if(extension == 'mp4'){
          this.el.classList.add('stickyNoteVideo');
        }else{
          this.el.classList.add('stickyNote');
        }
        this.el.classList.add('sticky'+ id);
        this.el.setAttribute('itemId', id); 
        var titleEl = document.createElement("h3");      
        var t = document.createTextNode(title);       
        titleEl.appendChild(t);                           
        this.el.appendChild(titleEl);    

        var descriptionEl = document.createElement("h4");       
        var t = document.createTextNode(description);       
        descriptionEl.appendChild(t);                         
        this.el.appendChild(descriptionEl);

        if(extension == 'mp4'){

          var thumbnail = document.createElement("video");   
          thumbnail.classList.add('stickyContentVideo');
          thumbnail.setAttribute('width',230);
          thumbnail.setAttribute('height',140);
          thumbnail.setAttribute('controls','');
          if(contentlink != " "){
              var source = document.createElement("source"); 
              source.setAttribute('src',"uploads/" + contentlink + "." + extension);
              source.setAttribute('type',"video/mp4");
          }
          thumbnail.appendChild(source);
          this.el.appendChild(thumbnail);

        }else if(contentlink != " "){

          var aThumbnail = document.createElement("a");   
          aThumbnail.classList.add('stickyContent');
          if(contentlink != " "){
          aThumbnail.setAttribute('href',"uploads/" + contentlink + "." + extension);
          }
          var thumbnail = document.createElement("div");   
          thumbnail.classList.add('stickyContent');
          if(contentlink != " "){
              thumbnail.style.backgroundImage = 'url(uploads/' + contentlink + '_th.' + extension + ')';
          }
          aThumbnail.appendChild(thumbnail);
          this.el.appendChild(aThumbnail);
        }

        var datumEl = document.createElement("p");   
        datumEl.classList.add('stickyDate');    
        var t = document.createTextNode("Aangemaakt op " + datum);       
        datumEl.appendChild(t);                     
        this.el.appendChild(datumEl);

        var creatorEl = document.createElement("p");   
        creatorEl.classList.add('stickyCreator');    
        var t = document.createTextNode("Door " + user);       
        creatorEl.appendChild(t);                     
        this.el.appendChild(creatorEl);

                 

        this.el.style.left = posX + "px";
        this.el.style.top = posY + "px";

        this.el.style.backgroundColor = color;
          
        //handlers binden
        this._mouseDownHandler = this.mouseDownHandler.bind(this);
        this._mouseMoveHandler = this.mouseMoveHandler.bind(this);
        this._mouseUpHandler = this.mouseUpHandler.bind(this);

        this.el.addEventListener('mousedown', this._mouseDownHandler);
      }

        Sticky.prototype.mouseDownHandler = function (event) {

            this.offsetX = event.offsetX;
            this.offsetY = event.offsetY;

            window.addEventListener('mousemove', this._mouseMoveHandler);
            window.addEventListener('mouseup', this._mouseUpHandler);

            teller++;
            this.el.style.zIndex = teller;
          }

          Sticky.prototype.mouseMoveHandler = function (event) {
            //move the sticky

            this.el.style.left = (event.pageX - this.offsetX) + 'px';
            this.el.style.top = (event.pageY - this.offsetY )+ 'px';
          }

          Sticky.prototype.mouseUpHandler = function (event) {
            //upload sticky pos to database

              $.ajax({
                type: "POST",
                url: 'index.php?page=moveItem',
                data: {id: this.el.getAttribute("itemId"),
                       x: this.el.style.left,
                       y: this.el.style.top,
                      },
                success: function(data) {
                console.log('success');
                console.log(data);
              },
                error: function(error) {
                console.log('error');
                console.log(error);
                }
              });

            window.removeEventListener('mousemove', this._mouseMoveHandler);
            window.removeEventListener('mouseup', this._mouseUpHandler);
          }
       

       init();
})();