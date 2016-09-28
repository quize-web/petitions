//////////////////////////////////////////////
// class="active" для навигации
//////////////////////////////////////////////

var currentUrl = document.URL;

var panelNavLinks = document.querySelectorAll("li > a");
var panelNavLinksArray = [].slice.call(panelNavLinks);

var currentLinks = panelNavLinksArray.filter(function(link) {
  return link.href == currentUrl;
});

var activeLis = currentLinks.filter(function(link) {
  return link.parentElement.classList.add("active");
});

//////////////////////////////////////////////
// добавление полей при создании шаблонов заявлений
//////////////////////////////////////////////

var fieldsArea = document.querySelector("#petition_fields");
var fieldTemplate = document.querySelector("#petition_field_template");
var addFieldButton = document.querySelector("#add_field");

addFieldButton.addEventListener("click", function (event) {
  event.preventDefault();

  var div = document.createElement("div");
  div.classList.add = "petition_field";
  div.innerHTML = fieldTemplate.innerHTML;
  fieldsArea.appendChild(div);
});

//////////////////////////////////////////////