<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
  var desc_id;

  $(function() {
    //DELETE ALL RECORD FROM DATABASE
    $(document).on('click', '#delete', function(e) {
      var id = $(this).data('id');
      $.ajax({
        type: 'POST',
        url: 'components/query_delete.php',
        data: {
          id: id,
        },
        dataType: 'json',
        success: function(response) {
          if (response.message == 'success') {
            $('#qty_' + id).remove();
            if (response.empty == 0) {
              $('table').append("<tbody id='empty_td'><tr><td colspan='6' align='center'>A table is empty</td></tr></tbody>");
              reset_input_form();
            }
            $('#toggleCard').hide();
            $('#changeButton').innerText = 'Add a Product';
          } else {
            alert(response.message);
          }
        }
      });
    });

    //DELETE SINGLE DESCRIPTION
    $(document).on('click', '#deleteSingle', function(e) {
      var id = $(this).data('id'); //GET products.id
      var desc_id = $(this).data('desc'); //GET products.id
      $.ajax({
        type: 'POST',
        url: 'components/query_deleteSingle.php',
        data: {
          desc_id: desc_id,
        },
        dataType: 'json',
        success: function(response) {
          $('.desc_' + desc_id).remove();
        }
      })

    });

    //ADD product TO DATABASE
    $(document).on('click', '#add', function(e) {
      var name = $('#inputName').val();
      if (name.length != 0) {
        var arr = [];
        $('textarea').each(function() {
          arr.push(this.value);
        });
        var price = $('#inputPrice').val();
        var category_id = $("#form-control option:selected").val();
        var category_name = $("#form-control option:selected").text();
        $.ajax({
          type: 'POST',
          url: 'components/query_add.php',
          data: {
            name: name,
            price: price,
            description: arr,
            category_id: category_id,
            category_name: category_name,
          },
          dataType: 'json',
          success: function(response) {
            if (response.message == 'Incorrect data entered') {

            } else {
              reset_input_form();
            }
            //alert(response.message);
            $('table').append(response.code);
            $('#empty_td').remove();

          }
        });
      } else {
        alert("Fill Name field!");
      }
    });

    /*when clicked #edit button GET information from DATABASE*/
    $(document).on('click', '#edit', function(e) {
      $("html, body").animate({
        scrollTop: 0
      }, "fast");
      var id = $(this).data('id');

      var x = document.getElementById("toggleCard");
      if (x.style.display === "none" && document.getElementById('changeButton').innerText === 'Add a Product' ||
        x.style.display === "block" && document.getElementById('changeButton').innerText === 'Close') {
        x.style.display = "block";
        document.getElementById('textProd').innerText = 'Edit a product';
        document.getElementById('changeButton').innerText = 'Close';
        document.getElementById('save').style.display = 'block';
        document.getElementById('add').style.display = 'none';
        $.ajax({
          type: 'POST',
          url: 'components/query_get.php',
          data: {
            id: id,
          },
          dataType: 'json',
          success: function(response) {
            $('#form-control').val(response.category_id).change();
            document.getElementById('inputName').value = response.name;
            document.getElementById('inputPrice').value = response.price;
            document.getElementById('inputDescription1').value = response.description[0];
            desc_id = response.desc_id;
            response.description.shift();
            $('#plus').hide();
            $('#clear').hide();
            response.description.forEach(element => {
              $('.text').append('<textarea class="form-control mb-3" id="inputDescription" rows="1">' + element + '</textarea>');
            });
            $('#save').data('id', response.id);
          }
        });
      }
    });

    /*when clicked #save button-> UPDATE information in DATABASE*/
    $(document).on('click', '#save', function(e) {
      var arr = [];
      $('textarea').each(function() {
        arr.push(this.value);
      });
      var id = $('#save').data('id');
      var name = $('#inputName').val();
      var price = $('#inputPrice').val();
      var category_id = $("#form-control option:selected").val();
      var category_name = $("#form-control option:selected").text();
      $.ajax({
        type: 'POST',
        url: 'components/query_update.php',
        data: {
          id: id,
          name: name,
          price: price,
          description: arr,
          category_id: category_id,
          category_name: category_name,
          desc_id: desc_id,
        },
        dataType: 'json',
        success: function(response) {
          //alert(response.message);
          if (response.message == 'success') {
            reset_input_form();
            $("#qty_" + id).html(response.code);
            $('#toggleCard').hide();
            $('#changeButton').html('Add a Product');
          }
        }
      });
    });

    /*when clicked "Add new description field" button*/
    $(document).on('click', '#plus', function(e) {
      $('.text').append('<textarea class="form-control mb-3" id="inputDescription" rows="1"></textarea>');
    });
    /*when clicked "remove"field button*/
    $(document).on('click', '#clear', function(e) {
      $('#inputDescription').remove();
      $('#inputDescription').append('<textarea class="form-control mb-3" id="inputDescription" rows="1"></textarea>');
    });
  });

  //_________________________________________
  // -----------Functions--------------------
  //_________________________________________

  //Toggle button Hide and Show
  function toggle() {
    $('#plus').show();
    $('#clear').show();
    var x = document.getElementById("toggleCard");
    if (x.style.display === "none") {
      x.style.display = "block";
      document.getElementById('textProd').innerText = 'Add a new product';
      document.getElementById('changeButton').innerText = 'Close';
      document.getElementById('add').style.display = 'block';
      document.getElementById('save').style.display = 'none';

    } else {
      x.style.display = "none";
      document.getElementById('changeButton').innerText = 'Add a Product';
      document.getElementById('add').style.display = 'none';
    }
    reset_input_form();
  }

  function reset_input_form() {
    $('#form-control').val('1').change();
    $('#inputName').val('');
    $('#inputPrice').val('');
    $('#inputDescription1').val('');
    $("textarea[id=inputDescription]").remove();
  }
</script>