let params = new URL(document.location).searchParams;
if (params.get("delete") != null) {
  swal({
    text: "Вы уверены, что хотите удалить этого ползователя?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      window.location = "deleteUser.php?deleteLogin=" + params.get("delete");
    } else {
      swal("Вы отменили удаление поьлзователя").then((willDelete) => {
        if (willDelete) {
          window.location = "users.php";
        } else {
          window.location = "users.php";
        }
      });
    }
  });
} else if (params.get("success") == 1) {
  swal("Вы успешно удалили пользователя", {
    icon: "success",
  }).then((willDelete) => {
    if (willDelete) {
      window.location = "users.php";
    } else {
      window.location = "users.php";
    }
  });
} else if (params.get("success") == 0) {
  swal("Вы не можете себя удалить", {
    icon: "error",
  }).then((willDelete) => {
    if (willDelete) {
      window.location = "users.php";
    } else {
      window.location = "users.php";
    }
  });
}
