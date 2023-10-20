$(".custom-select-picker").select2();
const fp = flatpickr(".flatpickr_date", {
  mode: "range",
  enableTime: true,
  dateFormat: "Y-m-d H:i",
  minDate: "",
  maxDate: "",
  defaultDate: ["", ""]
});
$("#checkAll").click(function (e) {
  e.stopPropagation();
  $("input:checkbox").not(this).prop("checked", this.checked);
});

function loadTable(table_id = "#basic-datatable", url = "", default_index = 0, where = null, extra_where = null) {
  // console.log('loadTable');
  // Create the DataTable instance
  $(`${table_id}`).DataTable({
    columnDefs: [
        { orderable: false, targets: 1 }
    ],
    destroy: true,
    scrollX: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: url,
      type: "GET",
      data: {
        where_condition: where,
        extra_where,
      },
    },
    
    order: [[default_index, "desc"]],
  });
}

function search_select_data(search_field, select_id) {
  let searchVal = $(`${search_field}`).val();
  let search_len = searchVal.length;
  if (search_len >= 2) {
    if ($(`#select2-${select_id}-results`).length > 0) {
      debounceCheck({
        select_id: select_id,
        select_results_id: search_field,
        search_val: searchVal,
      });
    }
  }
}

// calling debounce
const debounceCheck = debounce((obj) => {
  let select_id = obj.select_id;
  let select_results_id = obj.select_results_id;
  let search_val = obj.search_val;

  $.ajax({
    url: "https://www.jobaaj.com/authority/fun/company_search",
    type: "GET",
    data: {
      [select_id]: search_val,
    },
    cache: false,
    success: function (result) {
      result = "<option></option>" + result;
      if (!location.href.includes("add_jobs"))
        result = result.replace(
          "<option value='0'>Create New Company</option>",
          ""
        );
      let selectElem = $(`#${select_id}`);
      selectElem.html(result);
      selectElem.select2("destroy");
      selectElem.select2();
      selectElem.select2("open");
      // $(`#${select_results_id}`).parent().prev().find('.select2-search__field').val(search_val)
      $(`${select_results_id}`).val(search_val);
    },
    error: function (res) {
      //   alert(res + "sertgbn");
    },
  });
}, 250);

//  debounce function
function debounce(cb, delay = 1000) {
  let timeout;
  return (...args) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      cb(...args);
    }, delay);
  };
}



// ##############################################

let form_fields = $("#filter_block").find("input, select");
let setArray = [];

function clear_filter(element) {
  let nodeName = $(element).prop("nodeName");
  let name = $(element).attr("name");
  // console.log(nodeName, name);
  if (nodeName == "SELECT") {
    $(`[name='${name}'] option`)
      .first()
      .prop("selected", true)
      .trigger("change");
  } else if (nodeName == "INPUT") {
    $(`[name='${name}']`).val("");
  } else {
  }
}

$("#clear_filter").click(function () {
  form_fields.each(function () {
    clear_filter(this);
  });
  $("#search_filter").click();
});

$(document).on("click",".remove_filter",function(){
  let filter_selector = $(this).parent().attr('data-filter_selector');
  clear_filter($(`${filter_selector}`));
  $(this).parent().remove();
});

function search_filter(element){
  let val = $(element).val();
  let label_text = $(element).prev().text();
  let name = $(element).attr('name');
  let isDate = $(element).attr('data-isDate');
  let comma_separated = $(element).attr('data-comma_separated');
  let less_than = $(element).attr('data-less_than');
  let field = '';
  
  
  if(name=="cat_id" && val=='-2'){
      field = ` cat_id != 10 `;
  }
  else if(Array.isArray(val) && val.length!=0 && val[0]!=''){
    if(comma_separated=='true'){
      val = val.join(",");
      field = `CONCAT(',', ${name}, ',') LIKE '%,${val},%'`;
    }else {
      val = "'"+val.join("','")+"'";
      field = `${name} IN(${val})`;
    }
  }else if(val!=''){
    if(comma_separated=='true'){
      field = `CONCAT(',', ${name}, ',') LIKE '%,${val},%'`;
    }else if (isDate == 'true') {
      let date = val.split(" to ");
      
      let _to = Math.floor(Date.parse(date[1]) / 1000);
      let _from = Math.floor(Date.parse(date[0]) / 1000);
      
      field = `${name} between '${_from}' and '${_to}'`;
      
      
      
    }else if(less_than=='true'){
      field = `${name}<${val}`;
    } else{
      field = `${name}='${val}'`;
    }
  }
    
  if(field!=''){
    setArray.push(field);
    $("#filter_options").append(`<button type="button" data-filter_selector="#${name}" class="btn btn-filter text-white px-2 py-1 d-flex align-items-center justify-content-center"><span>${label_text} : ${val}</span><i class="uil uil-times-circle ml-2 remove_filter" style="margin-bottom:-5px"></i></button>`);
  }
}