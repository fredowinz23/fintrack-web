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

      var $_name = document.getElementById("c-name");
      var $_setNameValueEmpty = ($_name.value = "");

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
        var $_nameAttrValue = $_name.attr("data-name");

        // Get Modal Attributes
        var $_getModalIdInput = getModal.find("#c-id");
        var $_getModalNameInput = getModal.find("#c-name");

        // Set Modal Field's Value
        var $_setModalIdValue = $_getModalIdInput.val($_IdAttrValue);
        var $_setModalNameValue = $_getModalNameInput.val($_nameAttrValue);

        $("#addContactModal").modal("show");
      });
    }

    editContact();

  });
