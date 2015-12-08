$(document).ready(function() {
     
  var base_url = $('#hiddenBaseUrl').val();
  var uploadfolder = $('#uploadfolder').val();  
  console.log(base_url);
  $('#file_upload').uploadify({
    'swf'  : base_url + 'assets/js/uploadify/uploadify.swf',
    'uploader'    : base_url + 'zuploadify/uploadifyUploader/',
    'script'    : base_url + 'zuploadify/uploadifyUploader/',
    'cancelImg' : base_url + 'assets/js/uploadify/cancel.png',
    'fileExt'     : '*.jpg;*.gif;*.png;*.zip;*.rar;*.flv;*.mp4;*.mp3',
    'auto'      : false,
    'multi'     : true,
     
     'onComplete'  : function(event, ID, fileObj, response, data) {
          
         // here i'm gonna resize the images and display it in the main page 
         $.ajax({
            url : base_url + 'zuploadify/filemanipulation/' + fileObj.type +'/' + fileObj.name,
            success : function(response){
               
               if(response == 'image')
                 {
                   var images = $('<li><a target="_blank" href="'+base_url+'uploads/'+fileObj.name+'"><img src="'+base_url + 'uploads/thumbs/' +fileObj.name+'" alt=""></a></li><a target="_blank" href="'+base_url+'uploads/'+fileObj.name+'">');
                   $(images).hide().insertBefore('#displayFiles').slideDown('slow')
                 }
                  else
                 {
                   var files = $('</a><a href="'+base_url + 'uploads/thumbs/' +fileObj.name+'" target="_blank">'+fileObj.name+'</a>');
                   $(files).hide().insertBefore('#displayFiles').slideDown('slow')
                 }
            }
        })
    }
  });
   
  
});