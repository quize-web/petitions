var currentUrl = document.URL;

var panelNavLinks = document.querySelectorAll("li > a");
var panelNavLinksArray = [].slice.call(panelNavLinks);

var currentLinks = panelNavLinksArray.filter(function(link) {
  return link.href == currentUrl;
});

var activeLis = currentLinks.filter(function(link) {
  return link.parentElement.classList.add("active");
});
