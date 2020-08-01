$(".checkAll").change(function () {
  var state = this.checked;
  state
    ? $(":checkbox").prop("checked", true)
    : $(":checkbox").prop("checked", false);
  state
    ? $(this).next("b").text("Uncheck All")
    : $(this).next("b").text("Check All");
});

jQuery(".delete_all").on("click", function (e) {
  var allVals = [];
  $(".sub_chk:checked").each(function () {
    allVals.push($(this).attr("data-id"));
  });
  //alert(allVals.length); return false;
  if (allVals.length <= 0) {
    alert("Please select row.");
  } else {
    //$("#loading").show();
    WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";
    var check = confirm(WRN_PROFILE_DELETE);
    if (check == true) {
      //for server side
      /*
      var join_selected_values = allVals.join(","); 
      
      $.ajax({   
        
        type: "POST",  
        url: "delete.php",  
        cache:false,  
        data: 'ids='+join_selected_values,  
        success: function(response)  
        {   
          $("#loading").hide();  
          $("#msgdiv").html(response);
          //referesh table
        }   
      });*/
      //for client side
      $.each(allVals, function (index, value) {
        $("table tr")
          .filter("[data-row-id='" + value + "']")
          .remove();
      });
    }
  }
});
