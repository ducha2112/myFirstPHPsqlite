
// функции слайдера
let image_count = 6;
let interval = 8000;
let time_out = 25;
let i = 0;
let timeout;
let opacity = 100;

function change_image() {
 opacity--;
 let j = i + 1;
 let current_image = 'img_' + i;
 if (i === image_count) j = 1;
 let next_image = 'img_' + j;

 document.getElementById(current_image).style.opacity = (`${opacity}`/100).toString();
 document.getElementById(current_image).style.filter = 'opacity(' + opacity +' %)';
  document.getElementById(current_image).style.marginLeft = (100 - opacity)+'%';
 document.getElementById(next_image).style.opacity = ((100-`${opacity}`)/100).toString();
 document.getElementById(next_image).style.filter = 'opacity(('+100-opacity+') %)';
  document.getElementById(next_image).style.marginLeft = `0`;

 timeout = setTimeout("change_image()", time_out);
 if (opacity===1) {
  opacity = 100;
  clearTimeout(timeout);
 }
}
setInterval (function() {i++; if (i>image_count) i=1; change_image();}, interval);



const arr = [
 ['<div id="text1"><h1>«РОССИЙСКИЕ  ПОМЕСТЬЯ – ЭКО2»   это:</h1><h2>Комплексная,   межрегиональная,   самодостаточная,   саморазвивающаяся,     саморегулируемая   социально-экономическая   Система</h2></div>'],
     ['   <div id="text2"><h1>«РОССИЙСКИЕ  ПОМЕСТЬЯ – ЭКО2»   это:</h1><h2>Центр   адаптации   инновационных  технологий,    адаптации   современных   гражданских  прав   и   отношений</h2></div>'],
 ['<div id="text3"><h1>«РОССИЙСКИЕ  ПОМЕСТЬЯ – ЭКО2»   это:</h1><h2>Место для работы, творчества, жизни и отдыха, Здоровье и Перспектива</h2></div>'],
 ['<div id="text4"><h1>Продукция,  которую мы производим,</h1><h1>приносит здоровье  Человеку!</h1></div>'],
 ['<div id="text5"><h1>Чистоту  Природе!</h1></div>'],
 ['<div id="text6"><h1> А  прибыль…   только по труду! </h1></div>'],
];

let k=0;
let textCount = 5;
function changeText(){
 k++;
 let nextText = arr[k];
 const list = document.querySelector('.content');
 list.removeChild(list.firstElementChild);
 document.querySelector('.content').insertAdjacentHTML('afterbegin',(nextText).toString());

}
setInterval (function() { if (k ===textCount) k=-1; changeText();}, interval);

let liProjects = document.querySelector("#ins");
document.querySelector("#insert").addEventListener("pointerover",function (){
 let markup = `<span>Зарегистрируйтесь!</span>`;



 liProjects.insertAdjacentHTML("afterbegin",markup );

});
document.querySelector("#insert").addEventListener("pointerout",function (){

 liProjects.innerHTML='';
});