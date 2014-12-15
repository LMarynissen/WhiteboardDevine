var deleteButtons = document.querySelectorAll(".stickyDeleteButton");

    for(var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener("click",function(event){
            event.preventDefault(); 
            sendForm(this);
        });
    }


function sendForm(e){
    //Delete from database
    $.ajax({
        type: "POST",
        url: 'index.php?page=deleteItem',
        data: {id: e.getAttribute("itemId"),
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

    //Delete from current view
    console.log($(".sticky"+e.getAttribute("itemId")));
    $(".sticky"+e.getAttribute("itemId")).remove();




}
