<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Le Jeu du Trombone</title>
  <base href="/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/">
  <link rel="stylesheet" href="css/index.css">
  <style>
    body,html{height:100%;margin:0;}
    .container{display:flex;flex-direction:column;align-items:center;
      max-width:320px;padding:1rem;margin:auto;}
    button{cursor:pointer;border-radius:.5rem;}
    @media(max-width:480px){body{font-size:90%;}}
  </style>
</head>
<body>
<?php
require_once(
  $_SERVER['DOCUMENT_ROOT'] .
  '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/navbar.php'
);
?>
<div id="game" class="container">
  <h1>Le Jeu du Trombone 🔗</h1>
  <p id="clipsDisplay"></p>
  <p id="cashDisplay"></p>
  <div class="price-control">
    <button id="priceDown" aria-label="Baisser le prix">−</button>
    <span id="priceDisplay"></span>
    <button id="priceUp" aria-label="Augmenter le prix">+</button>
  </div>
  <button id="makeClip">Fabriquer un trombone</button>
  <button id="buyClipper"></button>
  <p id="clipperInfo"></p>
  <button id="buyMarketing"></button>
  <p id="marketingInfo"></p>
  <button id="resetGame">Nouvelle partie</button>
</div>
<?php
require_once(
  $_SERVER['DOCUMENT_ROOT'] .
  '/E5_petanque_MVC/LA_PETANQUE_LA_VRAI/include(redondance)/footer.php'
);
?>
<script>
let clips=0;
let cash=0;
let price=0.25;
let demand=10;
let marketingLevel=0;
let autoClippers=0;
const clipsDisplay=document.getElementById('clipsDisplay');
const cashDisplay=document.getElementById('cashDisplay');
const priceDisplay=document.getElementById('priceDisplay');
const priceDown=document.getElementById('priceDown');
const priceUp=document.getElementById('priceUp');
const makeClipBtn=document.getElementById('makeClip');
const buyClipperBtn=document.getElementById('buyClipper');
const clipperInfo=document.getElementById('clipperInfo');
const buyMarketingBtn=document.getElementById('buyMarketing');
const marketingInfo=document.getElementById('marketingInfo');
const resetGameBtn=document.getElementById('resetGame');

/** Met a jour l'affichage du jeu */
function updateUI(){
  clipsDisplay.textContent='Trombones : '+formatNumber(clips);
  cashDisplay.textContent='Trésorerie : '+formatMoney(cash)+' €';
  priceDisplay.textContent=formatMoney(price)+' €';
  buyClipperBtn.textContent='Acheter auto-clipper '+formatMoney(5+10*autoClippers)+' €';
  clipperInfo.textContent='Auto-clippers : '+autoClippers;
  buyMarketingBtn.textContent=
    'Campagne marketing '+formatMoney(10*Math.pow(10, marketingLevel))+' €';
  marketingInfo.textContent='Demande : '+demand;
}

/** Crée un trombone */
function makeClip(){
  clips++;
  updateUI();
}

/** Modifie le prix */
function changePrice(delta){
  price=Math.max(0.01,Math.round((price+delta)*100)/100);
  updateUI();
}

/** Achète un auto-clipper */
function buyClipper(){
  const cost=5+10*autoClippers;
  if(cash>=cost){cash-=cost;autoClippers++;updateUI();}
}

/** Achète une campagne marketing */
function buyMarketing(){
  const cost=10*Math.pow(10,marketingLevel);
  if(cash>=cost){cash-=cost;marketingLevel++;demand*=2;updateUI();}
}

/** Réinitialise la partie */
function resetGame(){
  clips=0;cash=0;price=0.25;demand=10;marketingLevel=0;autoClippers=0;
  localStorage.removeItem('paperclipGame_state');
  updateUI();
}

/** Boucle du jeu */
function gameTick(){
  clips+=autoClippers*0.5;
  const potentialSales=Math.floor(demand/price);
  const sales=Math.min(clips,potentialSales);
  clips-=sales;
  cash+=sales*price;
  updateUI();
}

/** Sauvegarde l'état */
function saveGame(){
  const state={clips,cash,price,demand,marketingLevel,autoClippers};
  localStorage.setItem('paperclipGame_state',JSON.stringify(state));
}

/** Charge l'état sauvegardé */
function loadGame(){
  const saved=localStorage.getItem('paperclipGame_state');
  if(saved){
    const s=JSON.parse(saved);
    clips=s.clips||0;
    cash=s.cash||0;
    price=s.price||0.25;
    demand=s.demand||10;
    marketingLevel=s.marketingLevel||0;
    autoClippers=s.autoClippers||0;
  }
}

function formatNumber(n){return Math.floor(n).toLocaleString('fr-FR');}
function formatMoney(n){
  return n.toLocaleString('fr-FR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}

document.addEventListener('DOMContentLoaded',()=>{
  loadGame();
  updateUI();
  makeClipBtn.addEventListener('click',makeClip);
  priceDown.addEventListener('click',()=>changePrice(-0.01));
  priceUp.addEventListener('click',()=>changePrice(0.01));
  buyClipperBtn.addEventListener('click',buyClipper);
  buyMarketingBtn.addEventListener('click',buyMarketing);
  resetGameBtn.addEventListener('click',resetGame);
  setInterval(gameTick,1000);
  setInterval(saveGame,5000);
});
</script>
</body>
</html>
