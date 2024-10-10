if (document.baseURI.includes("decouverte")) {
    let closeThanks = document.getElementById("closeThanksModal");

    if (closeThanks != null) {
        closeThanks.addEventListener("click", function () {
            document.getElementById("thanksModal").classList.add("hidden");
        })
    }
}
