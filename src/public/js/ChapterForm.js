function bissextile(annee){
  if(annee % 4== 0){
    if(annee % 400 == 0){
      return true;
    }
    return (annee % 100 != 0);
  }
  return false;
}

function options_days(id, nb_days){ 
  var part = 0;
  if(id == "1"){
    part = document.forms.chpform.deadline_day;
  } else {
    part = document.forms.chpform.avalable_day;
  }

  part.innerHTML = "";
  for(i=1; i<=nb_days; i++){
    part.options[part.options.length] = new Option(i,i);
  }
}

function year(id){
  var annee = 0;
  var mois = 0;

  if(id == "1"){
    annee = document.forms.chpform.deadline_year;
    mois  = document.forms.chpform.deadline_month;
  } else {
    annee = document.forms.chpform.avalable_year;    
    mois  = document.forms.chpform.avalable_month;
  }

  if(!bissextile(annee.options[annee.selectedIndex].value)){
    options_days(id, 28);
  } else if(mois.options[mois.selectedIndex].value == 2){
    options_days(id, 29);
  }
}

function month(id){
  var mois = 0;
  var annee = 0;

  if(id == "1"){
    mois  = document.forms.chpform.deadline_month;
    annee = document.forms.chpform.deadline_year;
  } else {
    mois  = document.forms.chpform.avalable_month;
    annee = document.forms.chpform.avalable_year;
  }
  mois = mois.options[mois.selectedIndex].value;

  if(mois == 1 || mois == 3 || mois == 5 || mois == 7 || mois == 10 || mois == 12){
    options_days(id, 31);
  } else if(mois == 4 || mois == 6 || mois == 9 || mois == 11){
    options_days(id, 30);    
  } else{
    if(!bissextile(annee.options[annee.selectedIndex].value)){
      options_days(id, 28);
    } else {
      options_days(id, 29);
    }
  }
};

function chpValid() {
  dy = document.forms.chpform.deadline_year;
  dm = document.forms.chpform.deadline_month;
  dd = document.forms.chpform.deadline_day;

  ay = document.forms.chpform.avalable_year;
  am = document.forms.chpform.avalable_month;
  ad = document.forms.chpform.avalable_day;

  dy = dy.options[dy.selectedIndex].value;
  dm = dm.options[dm.selectedIndex].value;
  dd = dd.options[dd.selectedIndex].value;

  ay = ay.options[ay.selectedIndex].value;
  am = am.options[am.selectedIndex].value;
  ad = ad.options[ad.selectedIndex].value;

  alert("chpValid");

  if(dy > ay){
    return true
  }
  if(dm > am){ 
    return true;
  }
  return (dd > ad);
};

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
s}

m = newCHPform();