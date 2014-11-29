(function(){

      var teller = 0;
        
      function init(){

          for(var i = 0; i < items.length; i++){
             var sticky = new Sticky(
             items[i].Color,
             items[i].contentlink,
             items[i].datum,
             items[i].description,
             items[i].extension,
             items[i].id,
             items[i].posX,
             items[i].posY,
             items[i].project_id,
             items[i].title,
             items[i].user_id
             );
             document.body.appendChild(sticky.el);
          }
      }

      function Sticky(Color, contentlink, datum, description, extension, id, posX, posY, project_id, title, user_id) {
           
        //aanmaken HTML-element
        this.el = document.createElement('div');
        this.el.classList.add('stickyNote');
         
        var titleEl = document.createElement("h3");      
        var t = document.createTextNode(title);       
        titleEl.appendChild(t);                           
        this.el.appendChild(titleEl);    

        var descriptionEl = document.createElement("h4");       
        var t = document.createTextNode(description);       
        descriptionEl.appendChild(t);                         
        this.el.appendChild(descriptionEl);    

        var thumbnail = document.createElement("div");   
        thumbnail.classList.add('stickyContent');
        thumbnail.style.backgroundImage = 'url(images/' + contentlink + '_th.' + extension + ')';
        this.el.appendChild(thumbnail);

        var datumEl = document.createElement("p");   
        datumEl.classList.add('stickyDate');    
        var t = document.createTextNode("aangemaakt op " + datum);       
        datumEl.appendChild(t);                     
        this.el.appendChild(datumEl);

        var creatorEl = document.createElement("p");   
        creatorEl.classList.add('stickyCreator');    
        var t = document.createTextNode("door " + user_id);       
        creatorEl.appendChild(t);                     
        this.el.appendChild(creatorEl);            

        this.el.style.left = posX + "px";
        this.el.style.top = posY + "px";

        this.el.style.backgroundColor = Color;
          
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
            console.log("mouseMoveHandler");
            this.el.style.left = (event.x - this.offsetX) + 'px';
            this.el.style.top = (event.y - this.offsetY )+ 'px';
          }

          Sticky.prototype.mouseUpHandler = function (event) {
            console.log("mouseUpHandler");

            window.removeEventListener('mousemove', this._mouseMoveHandler);
            window.removeEventListener('mouseup', this._mouseUpHandler);
          }
       

       init();
})();