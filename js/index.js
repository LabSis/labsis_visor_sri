$(document).ready(function(){    
    $('#btn_analyze').click(function(){
        var url = $('#txt_url').val();        
        $.ajax({
               url: '/visor_sri/src/ctrl/ajax/analyze_domain.ctrl.php',
               type: 'POST',
               dataType: 'json',
               data: {
                   url: url
               },
               success: function(response){
                   if(response.status === 'OK'){
                       show_result(response.data);
                   }else if(response.status === 'NO'){
                       show_error(response.message);
                   }
               }
            });
    });
        
});

function is_valid_url(url){
    return true;
}

function show_result(data_json){    
    var classification = data_json.classification;
    var url = data_json.url;
    var tags = data_json.tags;
    
    var html = "<div class='col-sm-10 offset-sm-1'><div class='card'><div class='card-header'>";
    html += '<a href="'+ url + '" target="_blank">'+ url + '</a>';
    html += '<p class="float-right"><strong>Classification:</strong>  '+ classification +'</p></div>';                            
    html += '<ul class="list-group list-group-flush">';
    for(var i = 0; i < tags.length; i++){
        tag = tags[i];
        console.log(tag);
        console.log(tag.usaCdn);
        html += '<li class="list-group-item">';
        
        html += '<ul>';        
        html += '<li><code>'+ escapeHtml(tag.tag)  +'</code></li>';
        html += '<li><strong>Use CDN: </strong> '+ ((tag.usaCdn === true)? 'YES':'NO') + '</li>';
        if (tag.usaCdn){
            console.log(tag.cdn);
            html += '<li><strong>CDN: </strong>'+ tag.cdn +'</li>'
            html += '<li><strong>Verify integrity: </strong>' + ((tag.verificaIntegridad)? 'YES':'NO') +'</li>';
            if(tag.verificaIntegridad){
                html += '<li><strong>Verify type: </strong>' + ((tag.tipoVerificacion)? tag.tipoVerificacion:'') +'</li>';
            }
        }
        html += '</ul>';
        html += '</li>';
    }
    html += '</ul></div></div>';
    $('#div_result').html(html);
}

function show_error(message){
    html = "<div class='col-sm-4 offset-sm-4 alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+message+"</div>";
    $('#div_result').html(html);
}

var entityMap = {
  '&': '&amp;',
  '<': '&lt;',
  '>': '&gt;',
  '"': '&quot;',
  "'": '&#39;',
  '/': '&#x2F;',
  '`': '&#x60;',
  '=': '&#x3D;'
};

function escapeHtml (string) {
  return String(string).replace(/[&<>"'`=\/]/g, function (s) {
    return entityMap[s];
  });
}

