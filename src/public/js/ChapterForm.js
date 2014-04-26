function dead_year(){
  var e = document.forms.chpform.deadline_year;
      e =  e.options[e.selectedIndex].value;
  alert("dead_year : " + e);
}

function dead_month(){
  var e = document.forms.chpform.deadline_month;
      e = e.options[e.selectedIndex].value;
  alert("dead_month : " + e);
}

function ava_year(){
  var e = document.forms.chpform.avalable_year;
      e =  e.options[e.selectedIndex].value;
  alert("ava_year : " + e);
}

function ava_month(){
  var e = document.forms.chpform.avalable_month;
      e =  e.options[e.selectedIndex].value;
  alert("ava_month : " + e);
}

function newCHPform(){


  var currentYear = new Date().getFullYear();


  document.forms.chpform.deadline_year.innerHTML = "";
  document.forms.chpform.deadline_month.innerHTML = "";
  document.forms.chpform.deadline_day.innerHTML = "";

  document.forms.chpform.avalable_year.innerHTML = "";
  document.forms.chpform.avalable_month.innerHTML = "";
  document.forms.chpform.avalable_day.innerHTML = "";

  /*init values*/

  for(i=currentYear; i<currentYear + 5; i++){
      document.forms.chpform.deadline_year.options[document.forms.chpform.deadline_year.options.length] = new Option(i,i);
      document.forms.chpform.avalable_year.options[document.forms.chpform.avalable_year.options.length] = new Option(i,i);
  }
 for(i=1; i<13; i++){
      document.forms.chpform.deadline_month.options[document.forms.chpform.deadline_month.options.length] = new Option(i,i);
      document.forms.chpform.avalable_month.options[document.forms.chpform.avalable_month.options.length] = new Option(i,i);
  }
 for(i=1; i<32; i++){
      document.forms.chpform.deadline_day.options[document.forms.chpform.deadline_day.options.length] = new Option(i,i);
      document.forms.chpform.avalable_day.options[document.forms.chpform.avalable_day.options.length] = new Option(i,i);
  }


}

m = newCHPform();

alert("ok syntaxe");
