

general_function();

$("#add_overtime").click(function(){

    var el = "";
    
    $("input[name=overtime_item]:checked").each(function(){
        el += '<input type="hidden" name="overtime[]" value="'+ $(this).val() +'" />';
    });

    general_el.parent().parent().find('.content_overtime').html(el);

    $("#modal_overtime").modal('hide');
});

$("#add_modal_bensin").click(function(){

    var cost = $('.modal-cost').val();

    general_el.parent().find("input[name='amount[]']").val(cost);   

    var tanggal     = $('.modal_tanggal_struk_bensin').val();
    var odo_from    = $('.modal_odo_from').val();
    var odo_to      = $('.modal_odo_to').val();
    var liter       = $('.modal_liter').val();
    var cost        = $('.modal_cost').val();

    var el = '<div class="bensin"><a class="btn btn-info btn-xs" onclick="info_bensin(this)"><i class="fa fa-info"></i></a><input type="hidden" name="bensin[tanggal][]" value="'+ tanggal +'" />';
        el += '<input type="hidden" name="bensin[odo_from][]" value="'+ odo_from +'" />';
        el += '<input type="hidden" name="bensin[odo_to][]" value="'+ odo_to +'" />';
        el += '<input type="hidden" name="bensin[liter][]" value="'+ liter +'" />';
        el += '<input type="hidden" name="bensin[cost][]" value="'+ cost +'" /></div>';

    general_el.parent().parent().find('.content_bensin').html(el);
    general_el.parent().parent().parent().parent().find("input[name='description[]']").val('Bensin');
    general_el.parent().parent().parent().parent().find("input[name='quantity[]']").val(liter);
    general_el.parent().parent().parent().parent().find("input[name='amount[]']").val(cost);

    $("#form_modal_bensin").trigger('reset');
    $("#modal_bensin").modal("hide");
});

function info_bensin(el)
{
    $("#modal_bensin").modal('show');

    var el = $(el).parent();

    var tanggal = el.find("input[name='bensin[tanggal][]']").val();
    var odo_from = el.find("input[name='bensin[odo_from][]']").val();
    var odo_to = el.find("input[name='bensin[odo_to][]']").val();
    var liter = el.find("input[name='bensin[liter][]']").val();
    var cost = el.find("input[name='bensin[cost][]']").val();

    $('.modal_tanggal_struk_bensin').val(tanggal);
    $('.modal_odo_from').val(odo_from);
    $('.modal_odo_to').val(odo_to);
    $('.modal_liter').val(liter);
    $('.modal_cost').val(cost);

    general_el = el.parent().parent().parent().find("select[name='type[]']");
}

$('#submit_payment').click(function(){

    if($('.table-content-lembur tr').length == 0)
    {
        return false;
    }

    bootbox.confirm("Apakah anda ingin Proses Payment Request ini ?", function(result) {
        if(result)
        {
            $("#form_payment").submit();
        }
    }); 
});

var general_el;

function general_function()
{
    $("select[name='type[]']").on('change', function(){

        if($(this).val() == 'Overtime Transport')
        {
            $("#modal_overtime").modal("show");
        }else if($(this).val() == 'Bensin')
        {
            $("#modal_bensin").modal("show");
        }else {
            $(this).parent().parent().find('.bensin').remove();
        }
        
        general_el = $(this);

    });
}

$("#add").click(function(){

    var no = $('.table-content-lembur tr').length;

    var html = '<tr>';
        html += '<td>'+ (no+1) +'</td>';
        html += '<td><div class="col-md-10" style="padding-left:0;">\
                        <select name="type[]" class="form-control">\
                        <option value=""> - none - </option>\
                        <option>Parkir</option>\
                        <option>Bensin</option>\
                        <option>Tol</option>\
                        <option>Overtime Transport</option>\
                        <option>Others</option></select></div>';

        html += '<div class="content_bensin"></div><div class="content_overtime"></div></td>';
        html += '<td class="description_td"><input type="text" class="form-control" name="description[]"></td>';
        html += '<td><input type="number" name="quantity[]" class="form-control" /></td>';
        html += '<td><input type="number" name="estimation_cost[]" class="form-control estimation" /></td>';
        html += '<td><input type="number" name="amount[]" class="form-control amount" /></td>';
        html += '<td><input type="number" name="amount_approved[]" class="form-control" readonly="true" /></td>';
        html += '<td><input type="file" name="file_struk[]" class="form-control" /></td>';
        html += '<td><a class="btn btn-xs btn-danger" onclick="delete_item(this);"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

    $('.table-content-lembur').append(html);

    $('.estimation').on('input', function(){
        
        var total = 0;

        $('.estimation').each(function(){

            if($(this).val() != "")
            {
                total += parseInt($(this).val());
            }
        });

        $('.total').html('Rp. '+ numberWithComma(total));
    });

    general_function();
});

function delete_item(el)
{
    if(confirm('Hapus data ini?'))
    {
        $(el).parent().parent().hide("slow", function(){
            $(el).parent().parent().remove();
        });
    }
}

