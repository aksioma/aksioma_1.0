var FormWizard = function () {
    return {
        //main function to initiate the module
        init: function () {
            var form1 = $('#form_sample_1');
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            $('#form_wizard_1 .button-next').click(function () {
                //error1.show();
                if($('#form_sample_1 input:eq(0)').val() == ""){
                    error1.show();
                    return false;
                }else{
                    error1.hide();
                }
            }).show();
            
            if (!jQuery().bootstrapWizard) {
                return;
            }
            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index) {
                    //alert('on tab click disabled');
                    return false;
                },
                onNext: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    // set wizard title
                    $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                    // set done steps
                    jQuery('li', $('#form_wizard_1')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }

                    if (current == 1) {
                        $('#form_wizard_1').find('.button-previous').hide();
                    } else {
                        $('#form_wizard_1').find('.button-previous').show();
                    }

                    if (current >= total) {
                        $('#form_wizard_1').find('.button-next').hide();
                        $('#form_wizard_1').find('.button-submit').show();
                    } else {
                        $('#form_wizard_1').find('.button-next').show();
                        $('#form_wizard_1').find('.button-submit').hide();
                    }
                    App.scrollTo($('.page-title'));
                },
                onPrevious: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    // set wizard title
                    $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                    // set done steps
                    jQuery('li', $('#form_wizard_1')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }

                    if (current == 1) {
                        $('#form_wizard_1').find('.button-previous').hide();
                    } else {
                        $('#form_wizard_1').find('.button-previous').show();
                    }

                    if (current >= total) {
                        $('#form_wizard_1').find('.button-next').hide();
                        $('#form_wizard_1').find('.button-submit').show();
                    } else {
                        $('#form_wizard_1').find('.button-next').show();
                        $('#form_wizard_1').find('.button-submit').hide();
                    }

                    App.scrollTo($('.page-title'));
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
                //alert('Finished! Hope you like it :)');
                id = ajak("base/nasabah/saveNasabah",$('#form_sample_1').serialize());
                if(id == "1"){
                    $("#table_datanasabah .reset").click();
                    window.location.href = "base/nasabah";
                }else if(id == "1062"){
                    ajak("base/nasabah/editNasabah",$('#form_sample_1').serialize());
                    $("#table_datanasabah .reset").click();
                    window.location.href = "base/nasabah";
                }
                
                $('#form_sample_1 input').val('');
                
                $('.nav-tabs li:eq(0)').removeClass('').addClass('active');
                $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
                $('#tabs-1').removeClass('').addClass('active');
                $('#tabs-2').removeClass('active').addClass('');
                
                $("#form_sample_1 input[name='tgl_masuk']").val(isitglskrg());
                var count = ajak('base/nasabah/run_code');
                var cab = ajak('base/nasabah/cab_code');
                $("#form_sample_1 input[name='nomor_nasabah']").val(count);
                $("#form_sample_1 input[name='code_wilayah']").val(cab);
        
                isi = ajak('base/nasabah/isi_propinsi');
                $("#propinsi").html(isi);
                $("#propinsi_pekerjaan").html(isi);
                $("#propinsi_usaha").html(isi);
                $("#propinsi_kerabat").html(isi);
            }).hide();
        }

    };

}();