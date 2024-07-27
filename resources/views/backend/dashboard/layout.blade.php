<!DOCTYPE html>
<html lang="en">
@include('backend.dashboard.component.head')
<body >
    <div id="wrapper">
        @include('backend.dashboard.component.silebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('backend.dashboard.component.nav')
                @include($template)
            </div>
            @include('backend.dashboard.component.footer')
        </div>
    </div>
    <button
    type="button"
    class="btn btn-secondary btn-floating btn-lg"
    id="btn-back-to-top">
    <i class="fas fa-angle-up"></i>
    </button>
    @include('backend.dashboard.component.script')
    <script>
        //Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
</body>
</html>