
    // $("#button").click(function(){
    //     let checkboxVal1 = [...document.querySelectorAll('input[name=checkbox]:checked')].map(e => e.value);
    //     console.log(checkboxVal1.toString())
    //   });
/********************************************************************************************/







    
      // let checkboxValue = [...document.querySelectorAll('input[name=checkbox]:checked')].map(e => e.value);
      let radioValue = document.querySelector('input[name="radio"]:checked').value;
      let colorValue = document.querySelector('input[name="color"]').value;
      let datetimeValue = document.querySelector('input[name="date"]').value;
      let datetimeLocalValue = document.querySelector('input[name="datetime_local"]').value;
      let rangeValue = document.querySelector('input[name="search"]').value;
      // let selectValue = document.querySelector('select[name="select"]').value;
/********************************************************************************************/





      
var columns = {
    text: 'Text',
    email: 'Email',
    password: 'Password',
    tel: 'Tel',
    number: 'Number',
    url: 'URL',
    search: 'Search',
    number_range: 'Number Range',
    color: 'Color',
    file: 'File',
    hidden: 'Hidden',
    checkbox: 'Checkbox',
    radio: 'Radio',
    time: 'Time',
    date: 'Date',
    week: 'Week',
    month: 'Month',
    datetime_local: 'Datetime Local'
}
var response;
     $(document).ready(function(){
        
        $.ajax({
          url: 'http://localhost:3000/allformdata',
          type: 'GET',        
          success:function(data) {
            response = data; 
            console.log(response.data);
            var table = $('#table-sortable').tableSortable({
                data: response.data,
                columns: columns,
                searchField: '#searchField',        
                rowsPerPage: 5,
                pagination: true,
            });
            $('#changeRows').on('change', function() { table.updateRowsPerPage(parseInt($(this).val(), 10)); });
            $('#rerender').click(function() { table.refresh(true); });
            $('#distory').click(function() { table.distroy(); });
            $('#refresh').click(function() { table.refresh(); });
            $('#setPage2').click(function() { table.setPage(1); });
          }
        });        
    }); 
    /*** For TABLE PLUGIN https://www.jqueryscript.net/table/Paginate-Sort-Filter-Table-Sortable.html#google_vignette **/
/********************************************************************************************/







    $("form#allforminput").submit(function (event) {

      var textVal = $('#text').val();
      var emailVal = $('#email').val();
      var passwordVal = $('#password').val();
      var telVal = $('#tel').val();
      var numberVal = $('#number').val();
      var urlVal = $('#url').val();
      var searchVal = $('#search').val();
      var number_rangeVal = $('#number_range').val();
      var colorVal = $('#color').val();
      var fileVal = $('#file').val();
      var hiddenVal = $('#hidden').val();
      var checkboxVal = [...document.querySelectorAll('input[name=checkbox]:checked')].map(e => e.value).toString();
      var radioVal = document.querySelector('input[name="radio"]:checked').value;
      var timeVal = $('#time').val();
      var dateVal = $('#date').val();
      var weekVal = $('#week').val();
      var monthVal = $('#month').val();
      var datetime_localVal = $('#datetime_local').val();


      var allInputTypeData = {
        text: textVal, email: emailVal, password: passwordVal, tel: telVal, number: numberVal, url: urlVal, search: searchVal, number_range: number_rangeVal, color: colorVal, file: fileVal, hidden: hiddenVal,
        checkbox: checkboxVal, radio: radioVal, time: timeVal, date: dateVal, week: weekVal, month: monthVal,
        datetime_local: datetime_localVal
      } 

      $.ajax({
          url: 'http://localhost:3000/allformdata',
          type: 'POST',
          data: JSON.stringify(allInputTypeData),
          contentType: 'application/json',
          success: function(data){
            console.log(data);
          }
        })
        .done(function(){console.log("Done")})
        .fail(function(){console.log("Fail")})
        event.preventDefault();  
    })
  /********************************************************************************************/






