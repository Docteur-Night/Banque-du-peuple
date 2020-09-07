$('document').ready(function(){

   $('#salaire').attr('disabled', true);
   $('#infos').attr('disabled', true);

        $('#etudiant').on('focusin', function(){
            $('#salaire').attr('disabled', true);
            $('#infos').attr('disabled', true);
        });

        $('#travailleur').on('focusin', function(){
            $('#salaire').attr('disabled', false);
            $('#infos').attr('disabled', false);
        });

  });