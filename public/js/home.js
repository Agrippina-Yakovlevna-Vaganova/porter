document.getElementById('batu').addEventListener('click',() => { 
  document.getElementById('form_div').classList.add("visible");
});

if(document.getElementsByClassName('postbutton')[0]){
document.getElementsByClassName('postbutton')[0].addEventListener('click',() => { 
  document.getElementById('form_div').classList.remove("visible");
});
}

//ファイル
var div_file = document.getElementById('input-file');
var input_file = document.getElementsByClassName('file')[0];
var button_file = document.getElementById('file_button');

div_file.addEventListener('click', ()=> {
  input_file.click();
  return false;
})

input_file.onchange = function() {
  //ファイル取得
 var file = input_file.files;
 var list = "";
 for(var i=0; i<file.length; i++){
   list += '<li>' + file[i].name + '</li>'
 }
 document.getElementById('filenames').innerHTML = list;
};







