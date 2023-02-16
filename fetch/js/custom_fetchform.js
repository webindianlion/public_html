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








/********* Get Users Data & render for table Starts **********/
    var response;
    $(document).ready(function(){      
      async  function fetchData(){
      fetch('https://inwebservice.com/api/users/', {method: 'GET'})
      .then(function(response){ return response.json(); })
      .then((data) => { createDataTabel(data.data) })
      .catch(function(error){console.log(error)})
      }
    fetchData();
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
        console.log(formData);

          fetch('https://inwebservice.com/api/users', 
          {method: 'POST', body: formData, 
          headers: { 'Content-Type': 'application/json'}
          })
          .then((res) => { return res.json()})
          .then((data) => { console.log(data); location.reload(true);})
          .catch((error) => {console.log(error)})

          event.preventDefault();        
      });
/*****************************************************************************************/









/********* Delete User Function Starts **********/
function deletedata(ids){
  const id = {id: ids};
  fetch('https://inwebservice.com/api/users',
      {method: 'DELETE', body: JSON.stringify(id), 
          headers: { 'Content-Type': 'application/json'}
      })
      .then((res)=>{return res.json()})
      .then((data)=>{console.log(data);location.reload(true);})
      .catch((error) => {console.log(error)})
}
/*****************************************************************************************/









/********* Edit User Form get data Starts **********/
    
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









/********* Edit User Form Post Starts **********/
$("form#m_userform").submit(function (event) {
        var formData = {
          first_name: $("#m_first_name").val(),
          last_name: $("#m_last_name").val(),
          gender: $("#m_gender").val(),
          email: $("#m_email").val(),
          password: $("#m_password").val(),
          number: $("#m_number").val(),
          id: $("#id").text()
        };
        
        formData = JSON.stringify(formData);
        console.log(formData);

          fetch('https://inwebservice.com/api/users', 
          {method: 'PUT', body: formData, 
          headers: { 'Content-Type': 'application/json'}
          })
          .then((res) => { return res.json()})
          .then((data) => { console.log(data); location.reload(true)})
          .catch((error) => {console.log(error)})

          event.preventDefault();        
      });

