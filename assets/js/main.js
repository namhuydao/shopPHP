$(document).ready(function(){
  $('.editBtn').on('click', function(){
    $('#editModal').modal('show');
    $tr = $(this).closest('tr');
    const data = $tr.children('td').map(function(){
      return $(this).text();
    }).get();
    $('#update_id').val(data[0]);
    $('#name').val(data[1]);
    $('#description').val(data[2]);
    $('#content').val(data[3]);
    $('#updateImgId').attr('src',$tr.children('.imgtd').children().attr('src'));

  })

  $('.deleteBtn').on('click', function(){
    $('#deleteModal').modal('show');
    $tr = $(this).closest('tr');
    const data = $tr.children('td').map(function(){
      return $(this).text();
    }).get();
    $('#delete_id').val(data[0]);
  })
  /*
  function loadData(page){
    $.ajax({
      url  : "pagination.php",
      type : "POST",
      cache: false,
      data : {page_no:page},
      success:function(response){
        console.log(response);
        $("#table-data").html(response);
      }
    });
  }
  loadData();

  // Pagination code
  $(document).on("click", ".pagination li a", function(e){
    e.preventDefault();
    var pageId = $(this).attr("id");
    loadData(pageId);
  });
   */
})