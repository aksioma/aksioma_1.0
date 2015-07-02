var FormValidation = function () {
    return {
        //main function to initiate the module
        init: function () {
            // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_tab');
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    tgl_dibuka: {
                        required: true
                    },
                    nomor_rekening: {
                        required: true
                    },
                    nomor_foname: {
                        required: true
                    },
                    nomor_nasabah: {
                        required: true
                    },
                    nisbah: {
                        number: true
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.help-inline').removeClass('ok'); // display OK icon
                    $(element)
                        .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change dony by hightlight
                    $(element)
                        .closest('.control-group').removeClass('error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
                    .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
                },
                submitHandler: function (form) {
                    success1.show();
                    error1.hide();
                    id = ajak("base/tabungan/saveTabungan",$('#form_tab').serialize());
                    if(id == "1"){
                        $("#table_datatabungan .reset").click();
                    }else if(id == "1062"){
                        ajak("base/tabungan/editTabungan",$('#form_tab').serialize());
                        $("#table_datatabungan .reset").click();
                    }
                    $('#form_tab input').val('');
                    $('#form_tab select').val('');
                    
                    $('.nav-tabs li:eq(0)').removeClass('').addClass('active');
                    $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
                    $('#tabs-1').removeClass('').addClass('active');
                    $('#tabs-2').removeClass('active').addClass('');
                    
                    $("#form_tab input[name='tgl_dibuka']").val(isitglskrg());
                    var count = ajak('base/tabungan/run_code');
                    var cab = ajak('base/tabungan/cab_code');
                    $("#form_tab input[name='nomor_rekening']").val(cab+"01"+count);
                    $("#info_nisbah").hide();
                }
            });
            
        }

    };

}();