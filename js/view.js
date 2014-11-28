(function(){

        
       function init(){
      
          //GEWOON EEN KLEIN TESTJE. MAG GEDELETE WORDEN :D
          var stickys = document.querySelectorAll('.stickyNote');
          console.log(stickys);
          [].forEach.call(stickys, function(sticky){
            console.log(sticky.style.left);
            sticky.style.left = 300+ "px";
            console.log(sticky.style.left);
            //sticky.addEventListener("mousedown", document.mousedownHandler.bind(this));
          });
        
       }
          
       
       init();
})();