var FormValidation = function () {
    return {
        //main function to initiate the module
        init: function () {
            // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_jamin');
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    nomor_jaminan: {
                        required: true
                    },
                    nomor_nasabah: {
                        required: true
                    },
                    nilai_jaminan: {
                        required: true,
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
                    id = ajak("base/jaminan/savejaminan",$('#form_jamin').serialize());
                    if(id == "1"){
                        $("#table_datajaminan .reset").click();
                    }else if(id == "1062"){
                        ajak("base/jaminan/editjaminan",$('#form_jamin').serialize());
                        $("#table_datajaminan .reset").click();
                    }
                    $('#form_jamin input').val('');
                    $('#form_jamin select').val('');
                    $('#form_jamin textarea').val('');
                    
                    $('.nav-tabs li:eq(0)').removeClass('').addClass('active');
                    $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
                    $('#tabs-1').removeClass('').addClass('active');
                    $('#tabs-2').removeClass('active').addClass('');
                    
                    var count = ajak('base/jaminan/run_code');
                    var cab = ajak('base/jaminan/cab_code');
                    $("#form_jamin input[name='nomor_jaminan']").val(cab+""+count);
                }
            });
            
        }

    };

}();