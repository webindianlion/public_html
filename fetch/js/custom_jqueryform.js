/********* Create User Table Function Starts **********/
function createDataTabel(response) {
    $.each(response, function(i, item) {
        $('<tr>').html(                        
              `<td class='id d-none'> ${item.id} </td>
              <td class='firstName'>${item.firstName}</td>
              <td class='lastName'>${item.lastName}</td>
              <td class='gender'>${item.gender}</td>
              <td class='email'>${item.email}</td>
              <td class='number'>${item.number}</td>
              <td class="trash"> 
                <i class="fa-solid fa-trash-can" onclick="deletedata(${item.id})"></i> <i class="fa-solid fa-pen-to-square" onclick="editdata()" data-bs-toggle="modal" data-bs-target="#exampleModal"></i> </td>`
        ).appendTo('#records_table thead');
    });                
  } 
  /*****************************************************************************************/





  
  /********* Get Users Data Function Starts **********/
    var response;
      $(document).ready(function(){
        
          $.ajax({
            url: 'https://inwebservice.com/api/users/',
            type: 'GET',          
            success:function(data) {
              response = data; 
              createDataTabel(response.data);
              console.log(response.data);
            }
          });
      });    
  /*****************************************************************************************/







  
  /********* Add User Function Starts **********/
      $("form#userform").submit(function (event) {
          var formData = {
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            gender: $("#gender").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            number: $("#number").val()
          };
          
          formData = JSON.stringify(formData);
          // console.log(formData);
  
          $.ajax({
              method: 'POST',
              url: 'https://inwebservice.com/api/users',
              data: formData,
              contentType: 'application/json',
              success:function(data) { console.log(data) }
            }).done(function(){
                location.reload(true);
            }).fail(function(err){ console.log(data) });
            event.preventDefault();        
        });
  /*****************************************************************************************/






  
  /********* Update User Function Starts **********/
  $("form#m_userform").submit(function (event) {
          var formData = {
            first_name: $("#m_first_name").val(),
            last_name: $("#m_last_name").val(),
            gender: $("#m_gender").val(),
            email: $("#m_email").val(),
            number: $("#m_number").val(),
            id: $("#id").text(),
            password: ""
          };
          
          formData = JSON.stringify(formData);
          console.log(formData);
  
          $.ajax({
              method: 'PUT',
              url: 'https://inwebservice.com/api/users',
              data: formData,
              contentType: 'application/json',
              success:function(data) { console.log(data) }
            })
            .done(function(){ location.reload(true);})
            .fail(function(err){ console.log("fail") });
            event.preventDefault();        
        });
  /*****************************************************************************************/






  
  /********* Delete User Function Starts **********/
       function deletedata(ids){
        var iddata = {id:ids};
        iddata = JSON.stringify(iddata);
        console.log(iddata)
          $.ajax({
            type: 'DELETE',
            url: 'https://inwebservice.com/api/users/',          
            data: iddata,
            contentType: 'application/json',
            success:function(data) {  console.log(data); }
          }).done(function(){
              location.reload(true);
          }).fail(function(err){ console.log("fail") });
      };
  
  /*****************************************************************************************/







  
  /********* Edit User Function Starts **********/
      
  function editdata(item){
    const  edit = event.target;
  const id = $(edit).parent().parent().children(".id").text();
  const fname = $(edit).parent().parent().children(".firstName").text();
  const lname = $(edit).parent().parent().children(".lastName").text();
  const gender = $(edit).parent().parent().children(".gender").text();
  const email = $(edit).parent().parent().children(".email").text();
  const number = $(edit).parent().parent().children(".number").text();
  
    $("#m_first_name").val(fname);
    $("#m_last_name").val(lname);
    $("#m_gender").val(gender);
    $("#m_email").val(email);
    $("#m_number").val(number);
    $("#m_number").val(number);
    $("#id").text(id);
  
  }
  
  /*****************************************************************************************/
   
 






  /********* Form Mobile Validation Starts **********/
  $("#number").focusout(  
    function phonenumber(){
      var num = $("#number").val();
      console.log(num);
    var phoneno = /[0-9]/;
    if(num.match(phoneno)){ return true; }
    else{
      alert("Please use numbers only for mobile");
      return false;
    }
  } );
  /*****************************************************************************************/







  
  
  $(document).ready(function(){
  
    $(".fn-warn").hide();
    $(".ln-warn").hide();
    
    /********* first_name Validation Starts **********/
    $("#first_name").focusout(   
        function (){    
        let first_name_val = $("#first_name").val();
        let phoneno = /[A-Z]\w+/gi;
        if(first_name_val.match(phoneno)){ $(".fn-warn").hide(); console.log(first_name_val); return true; }
        else{
            $(".fn-warn").show();
            return false;
        } } );
  /********* last_name Validation Starts **********/
    $("#last_name").focusout(   
        function(){    
        let last_name_val = $("#last_name").val();    
        let phoneno = /[A-Z]\w+/gi;
        if(last_name_val.match(phoneno)){ $(".ln-warn").hide(); return true; }
        else{
        $(".ln-warn").show();
        return false;
    } } );
  
  });
  
   // {    
  //     "first_name": "Teena",
  //     "last_name": "Kumari",
  //     "gender": "F",
  //     "email": "Nonu@kumar.com",
  //     "password": "ttt",
  //     "number": 321
  // }