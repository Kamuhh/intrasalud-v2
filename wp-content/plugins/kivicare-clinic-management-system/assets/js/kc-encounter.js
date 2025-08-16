(function($){
  // Llama este método cuando abras el modal
  window.kcLoadEncounterSummary = function(encounterId, patientId){
    $.ajax({
      url: ajaxurl || (window.kcAjaxUrl || '/wp-admin/admin-ajax.php'),
      method: 'POST',
      dataType: 'json',
      data: {
        action: 'kc_get_encounter_summary',
        encounter_id: encounterId,
        patient_id: patientId
      },
      success: function(res){
        if(!res || !res.success){ return; }
        var p = res.data.patient || {};
        var e = res.data.encounter || {};
        var $root = $('.kc-modal.kc-modal-summary');
        if($root.length){
          $root.attr('data-encounter-id', encounterId);
          $root.attr('data-patient-id', patientId);
          $root.attr('data-patient-email', p.email || '');
        }

        // Paciente
        $('#kc-sum-name').text(p.name || '');
        $('#kc-sum-email').text(p.email || '');
        $('#kc-sum-ci').text(p.ci || '');
        $('#kc-sum-dob').text(p.dob || '');
        $('#kc-sum-gender').text(p.gender_es || '');

        // Listas
        function fillList($ul, items){
          $ul.empty();
          if(items && items.length){
            items.forEach(function(t, idx){
              $('<li/>').text((idx+1)+'. '+t).appendTo($ul);
            });
          } else {
            $('<li/>').text('No se encontraron registros').appendTo($ul);
          }
        }

        fillList($('#kc-sum-dx-list'), e.diagnosticos || []);
        fillList($('#kc-sum-orders-list'), e.ordenes || []);
        fillList($('#kc-sum-ind-list'), e.indicaciones || []);
      },
      error: function(){
        alert('Error de red');
      }
    });
  };
})(jQuery);
