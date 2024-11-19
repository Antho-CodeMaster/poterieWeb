if (document.baseURI.includes('admin/articles')) {
    let selectEtat = document.getElementById("etat");
    let sensible = document.getElementById("sensible");
    let vedette = document.getElementById("vedette");
    let filterForm = document.getElementById("filterForm");
    let pageLink = document.getElementsByClassName("pageLink");

    selectEtat.addEventListener("change", function(){filterForm.submit();});
    sensible.addEventListener("change", function(){filterForm.submit();});
    vedette.addEventListener("change", function(){filterForm.submit();});

    for(let i = 0; i < pageLink.length; i++)
    {
        pageLink[i].addEventListener("click", function(){
            document.getElementById("pageID").value = parseInt(pageLink[i].innerHTML);
            filterForm.submit();
        });
    }
}

