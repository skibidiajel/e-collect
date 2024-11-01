function changeTab(){
  const navLinkActives = document.querySelectorAll('.nav-item');
  navLinkActives.forEach(navLinkActive => {
    navLinkActive.addEventListener('click', () => {
      document.querySelector(".active")?.classList.remove("active");
      navLinkActive.classList.add("active");
    })
  })
}

function hamMenuActive(){
  const hamMenu = document.querySelector('.ham-menu');
  const navLink = document.querySelector('.navigation-list');

  hamMenu.classList.toggle('active');
  navLink.classList.toggle('active');
}

function unmatchedCreds(un){
  let showError = document.querySelector('span');
  showError.classList.remove("show-error");
}

function logout(){
  window.location.replace("../frontend/functions/logout.php");
}

// FUNCTION FOR NEW TRANSACTIONS
function goToTransactions(passedData){
  window.location.href = "./transactions.php";
}

// FUNCTION FOR MODAL/POPUP
function addUser(){
  document.getElementById("modal").style.display = "block";
  document.getElementById("add-modal").style.display = "block";
}

// FUNCTION FOR CANCEL MODAL/POPUP
function userAddCancel(){
  document.getElementById("modal").style.display = "none";
  document.getElementById("add-modal").style.display = "none";
}

// FUNCTION FOR EDIT MODAL
function showEditModal(username, password, id){
  document.getElementById("modal").style.display = "block";
  document.getElementById("edit-modal").style.display = "block";
  document.getElementById("edit-id").value = id;
  document.getElementById("edit-username").value = username;
  document.getElementById("edit-password").value = password;
}

// FUNCTION FOR DELETE MODAL
function showDeleteModal(id){
  document.getElementById("modal").style.display = "block";
  document.getElementById("delete-modal").style.display = "block";
  document.getElementById("delete-id").value = id;
}

// FUNCTION FOR ADD COIN
function addCoin(){
  document.getElementById("modal").style.display = "block";
  document.getElementById("add-coin").style.display = "block";
}

// FUNCTION FOR CLEAR COIN
function clearCoin(){
  document.getElementById("modal").style.display = "block";
  document.getElementById("clear-coin").style.display = "block";
}

// FUNCTION FOR CANCEL COIN
function coinAddCancel(){
  document.getElementById("modal").style.display = "none";
  document.getElementById("add-coin").style.display = "none";
}
