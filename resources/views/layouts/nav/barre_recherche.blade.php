<!-- Barre de recherche -->
<div class="hidden lg:block w-[500px]">
    <form action="{{ route('recherche.getSearch') }}" method="GET" class="w-full h-[38px] py-auto">
        <input class="w-full rounded h-full" type="text"
            placeholder="Rechercher des articles ou des artistes..." name="query">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
</div>
