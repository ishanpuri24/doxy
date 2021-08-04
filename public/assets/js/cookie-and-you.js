const webName = 'cookiesAndYou';

const siteUrl = 'http://cookieandyou.com';

const localStorageValue = 'isCookiesAccepted';

const info = 'This site uses cookies to ensure you get the latest experience on our website.';



(function renderTemplate() {

  let queryParam = getTemplateID();



  const isCookiesAccepted = localStorage.getItem(localStorageValue);

  if (isCookiesAccepted !== 'true') {

    switch (queryParam) {

      default:

        renderDefault();

        break;

    }

  }

})();





// GET TEMPATE ID FROM QUERY PARAMS

function getTemplateID() {

  const queryParams = new RegExp('[\?&]' + 'T' + '=([^&#]*)')

    .exec(window.location.search);



  return queryParams ? queryParams[1] : '';

}



// DEFAULT TEMPLATE

function renderDefault() {

  let body = document.querySelector("body");



  // CREATE OUTER TAG

  let div = document.createElement('div');

  div.id = webName;

  div.style.position = 'fixed';

  div.style.bottom = 0;

  div.style.left = 0;

  div.style.right = 0;

  div.style.background = '#212c41';

  div.style.color = '#f1f1f1';

  div.style.padding = '20px';

  div.style.display = 'flex';

  div.style.justifyContent = 'space-between';

  div.style.alignItems = 'center';

  div.style.zIndex = 2147483647;





  // CREATE CHILD TAG

  let pTag = document.createElement('p');

  pTag.innerHTML = info;

  pTag.style.color = "#fff";

  pTag.style.marginBottom = 0;

  pTag.style.padding = 0;

  pTag.style.marginRight = '10px';
  
  pTag.style.textAlign = 'justify';






  // CREATE INNER CHILD TAG

  let aTag = document.createElement('a');

  aTag.innerHTML = "Learn more about cookies";

  aTag.href = siteUrl;

  aTag.target = "_blank";

  aTag.style.textDecoration = 'none';

  aTag.style.marginLeft = '5px';

  aTag.style.color = '#fff';

  aTag.style.paddingBottom = '1px';

  aTag.style.borderBottom = 'solid';

  aTag.style.borderColor = '#fff';

  aTag.style.borderWidth = '1px';



  pTag.append(aTag);





  // CREATE CHILD TAG

  let button = document.createElement('button');

  button.innerHTML = 'Got it!';

  button.style.background = '#4636ff';

  button.style.color = '#fff';

  button.style.border = '0';

  button.style.padding = '7px 25px';

  button.style.cursor = 'pointer';

  button.style['white-space'] = "pre";

  button.addEventListener('click', () => {

    div.style.display = 'none';

    localStorage.setItem(localStorageValue, 'true');

  })





  const childs = [pTag, button];

  div.append(...childs);

  body.append(div);
}