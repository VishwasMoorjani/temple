<!--   Core JS Files   -->


  <script src="<?=base_url('/assets/admin/js/core/popper.min.js'); ?>"></script>
  <script src="<?=base_url('/assets/admin/js/core/bootstrap.min.js'); ?>"></script>
  <script src="<?=base_url('/assets/admin/js/plugins/perfect-scrollbar.min.js'); ?>"></script>
  <script src="<?=base_url('/assets/admin/js/plugins/smooth-scrollbar.min.js'); ?>"></script>
  <script src="<?=base_url('/assets/admin/js/plugins/choices.min.js'); ?>"></script>
  <script src="<?php //echo base_url('/assets/admin/js/plugins/dropzone.min.js'); ?>"></script>
  <!-- <script src="<?php //echo base_url('/assets/admin/js/plugins/quill.min.js'); ?>"></script> -->
  <script src="<?=base_url('/assets/admin/js/fSelect.js'); ?>"></script>
  <script src="<?=base_url('/assets/admin/js/plugins/multistep-form.js'); ?>"></script>
  <script src="<?=base_url('/assets/admin/js/plugins/chartjs.min.js'); ?>"></script>
  <script src="<?=base_url('/assets/admin/js/plugins/datatables.js'); ?>"></script>
  <script>
    if (document.getElementById('edit-deschiption')) {
      var quill = new Quill('#edit-deschiption', {
        theme: 'snow' // Specify theme in configuration
      });
    };

    if (document.getElementById('choices-category')) {
      var element = document.getElementById('choices-category');
      const example = new Choices(element, {
        searchEnabled: false
      });
    };

    if (document.getElementById('choices-sizes')) {
      var element = document.getElementById('choices-sizes');
      const example = new Choices(element, {
        searchEnabled: false
      });
    };

    if (document.getElementById('choices-currency')) {
      var element = document.getElementById('choices-currency');
      const example = new Choices(element, {
        searchEnabled: false
      });
    };

    if (document.getElementById('choices-tags')) {
      var tags = document.getElementById('choices-tags');
      const examples = new Choices(tags, {
        removeItemButton: true
      });

      examples.setChoices(
        [{
            value: 'One',
            label: 'Expired',
            disabled: true
          },
          {
            value: 'Two',
            label: 'Out of Stock',
            selected: true
          }
        ],
        'value',
        'label',
        false,
      );
    }
  </script>
  <!-- Kanban scripts -->
  <script src="<?=base_url('/assets/admin/js/plugins/dragula/dragula.min.js'); ?>"></script>
  <script src="<?=base_url('/assets/admin/js/plugins/jkanban/jkanban.js'); ?>"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script>
          (function($) {
          $(function() {
              window.fs_test = $('.chosen-select').fSelect();
          });
      })(jQuery);
    </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
   <script src="<?=base_url('/assets/admin/js/material-dashboard.min.js?v=3.0.5'); ?>"></script> 
</body>

</html>