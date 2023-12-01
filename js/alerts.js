(function ($) {
  showSwal = function (type) {
    "use strict";
    if (type === "basic") {
      swal({
        text: "Any fool can use a computer",
        button: {
          text: "OK",
          value: true,
          visible: true,
          className: "btn btn-primary",
        },
      });
    } else if (type === "title-and-text") {
      swal({
        title: "Read the alert!",
        text: "Click OK to close this alert",
        button: {
          text: "OK",
          value: true,
          visible: true,
          className: "btn btn-primary",
        },
      });
    } else if (type === "success-message") {
      swal({
        title: "Successfull!",
        text: "",
        icon: "success",
        button: {
          text: "Okay",
          value: true,
          visible: true,
          className: "btn btn-primary",
        },
      });
    } else if (type === "auto-close") {
      swal({
        title: "Wait to finish sending",
        text: "It may take some seconds depending on the number of tenants",
        timer: 3000,
        button: false,
      }).then(
        function () {},
        // handling the promise rejection
        function (dismiss) {
          if (dismiss === "timer") {
          }
        }
      );
    } else if (type === "warning-message-and-cancel") {
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3f51b5",
        cancelButtonColor: "#ff4081",
        confirmButtonText: "Great ",
        buttons: {
          cancel: {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-danger",
            closeModal: true,
          },
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true,
          },
        },
      });
    } else if (type === "warning-message-without-cancel") {
      swal({
        title: "Username already exists!",
        text: "",
        icon: "warning",
        showCancelButton: false,
        confirmButtonColor: "#3f51b5",
        cancelButtonColor: "#ff4081",
        confirmButtonText: "Ok",
        buttons: {
          cancel: {
            text: "Cancel",
            value: null,
            visible: false,
            className: "btn btn-danger",
            closeModal: true,
          },
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true,
          },
        },
      });
    } else if (type === "server-message-without-cancel") {
      swal({
        title: "Server Error!",
        text: "",
        icon: "warning",
        showCancelButton: false,
        confirmButtonColor: "#3f51b5",
        cancelButtonColor: "#ff4081",
        confirmButtonText: "Ok",
        buttons: {
          cancel: {
            text: "Cancel",
            value: null,
            visible: false,
            className: "btn btn-danger",
            closeModal: true,
          },
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true,
          },
        },
      });
    } else if (type === "custom-html") {
      swal({
        content: {
          element: "input",
          attributes: {
            placeholder: "Type your password",
            type: "password",
            class: "form-control",
          },
        },
        button: {
          text: "OK",
          value: true,
          visible: true,
          className: "btn btn-primary",
        },
      });
    }
  };
})(jQuery);
