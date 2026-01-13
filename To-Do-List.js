const inputbox = document.getElementById('input-box');
const listContainer =document.getElementById('list-container');

function addTask(){
  if(inputbox.value === ''){
    alert("you must write something!"); 

  }
  else{
    let li =document.createElement("li");
    li.innerText = inputbox.value;
    listContainer.appendChild(li);

    let span =document.createElement("span");
    span.innerHTML="\u00d7"
    li.appendChild(span);
  }

     inputbox.value = "";
  
}

listContainer.addEventListener("click",function(e){
  if(e.target.tagName === "Li"){
    e.target.classList.toggle("checks");
  }
  else if(e.target.tagName ==="SPAN"){
    e.target.parentElement.remove();
}
},false);