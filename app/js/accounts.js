$(function () {

    $("#input-search").on("keyup", function () {
      var rex = new RegExp($(this).val(), "i");
      $(".search-table .search-items:not(.header-item)").hide();
      $(".search-table .search-items:not(.header-item)")
        .filter(function () {
          return rex.test($(this).text());
        })
        .show();
    });

    $("#btn-add-contact").on("click", function (event) {

      var $_username = document.getElementById("c-username");
      $_username.value = "";

      var $_generatedpw = Math.floor(Math.random()*899999+100000);

      var $_password = document.getElementById("c-password");
      $_password.value = $_generatedpw;

      var $_dpassword = document.getElementById("c-display-password");
      $_dpassword.value = $_generatedpw;

      $("#addContactModal #btn-add").show();
      $("#addContactModal #btn-edit").hide();
      $("#addContactModal").modal("show");
    });


    function editContact() {
      $(".edit").on("click", function (event) {
        $("#addContactModal #btn-add").hide();
        $("#addContactModal #btn-edit").show();

        // Get Parents
        var getParentItem = $(this).parents(".search-items");
        var getModal = $("#addContactModal");

        // Get List Item Fields
        var $_name = getParentItem.find(".user-name");

        // Get Attributes
        var $_IdAttrValue = $_name.attr("data-id");
        var $_usernameAttrValue = $_name.attr("data-username");
        var $_firstNameAttrValue = $_name.attr("data-firstName");
        var $_lastNameAttrValue = $_name.attr("data-lastName");

        // Get Modal Attributes
        var $_getModalIdInput = getModal.find("#c-id");
        var $_getModalUsernameInput = getModal.find("#c-username");
        var $_getModalFirstNameInput = getModal.find("#c-firstName");
        var $_getModalLastNameInput = getModal.find("#c-lastName");

        // Set Modal Field's Value
        $_getModalIdInput.val($_IdAttrValue);
        $_getModalUsernameInput.val($_usernameAttrValue);
        $_getModalFirstNameInput.val($_firstNameAttrValue);
        $_getModalLastNameInput.val($_lastNameAttrValue);

        $("#addContactModal").modal("show");
      });
    }

    editContact();

  });
