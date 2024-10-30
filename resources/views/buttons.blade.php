<x-app-layout>
    <div class="m-4">
        <div class="my-2 pl-2 border border-black">
            <h1>red</h1>
            <div class="flex p-2 gap-2">
                <x-button.red.down>down</x-button.red.down>
                {{-- Possible d'ajouter des attributs --}}
                <x-button.red.trash id="lol">trash</x-button.red.trash>
                {{-- Possible d'override des attributs --}}
                <x-button.red.x type="button">x</x-button.red.x>
                <x-button.red.exclamation>exclamation</x-button.red.exclamation>
                <x-button.red.flag>flag</x-button.red.flag>
            </div>
        </div>
        <div class="my-2 pl-2 border border-black">
            <h1>blue</h1>
            <div class="flex p-2 gap-2 wrap">
                <x-button.blue.add-pic>add-pic</x-button.blue.add-pic>
                <x-button.blue.clipboard-check>clipboard-check</x-button.blue.clipboard-check>
                <x-button.blue.upload>upload</x-button.blue.upload>
                <x-button.blue.leave>leave</x-button.blue.leave>
                <x-button.blue.info>info</x-button.blue.info>
                <x-button.blue.question>question</x-button.blue.question>
                <x-button.blue.edit>edit</x-button.blue.edit>
                <x-button.blue.settings>settings</x-button.blue.settings>
                <x-button.blue.filter>filter</x-button.blue.filter>
            </div>
        </div>
        <div class="my-2 pl-2 border border-black">
            <h1>green</h1>
            <div class="flex p-2 gap-2">
                <x-button.green.check>check</x-button.green.check>
                <x-button.green.award>award</x-button.green.award>
                <x-button.green.card>card</x-button.green.card>
                <x-button.green.pay>pay</x-button.green.pay>
                <x-button.green.plus>plus</x-button.green.plus>
                <x-button.green.send>send</x-button.green.send>
            </div>
        </div>
        <div class="my-2 pl-2 border border-black">
            <h1>yellow</h1>
            <div class="flex p-2 gap-2">
                <x-button.yellow.exclamation>exclamation</x-button.yellow.exclamation>
            </div>
        </div>
        <div class="my-2 pl-2 border border-black">
            <h1>border</h1>
            <div class="flex p-2 gap-2">
                <x-button.border.filter>filter</x-button.border.filter>
                <x-button.border.cart>cart</x-button.border.cart>
            </div>
        </div>
        <div class="my-2 pl-2 border border-black">
            <h1>none</h1>
            <div class="flex p-2 gap-2">
                <x-button.none.filter>filter</x-button.none.filter>
            </div>
        </div>
        <div class="my-2 pl-2 border border-black">
            <h1>Sans texte</h1>
            <div class="flex p-2 gap-2 wrap">
                <x-button.red.down></x-button.red.down>
                <x-button.red.trash></x-button.red.trash>
                <x-button.red.x></x-button.red.x>
                <x-button.red.exclamation></x-button.red.exclamation>
                <x-button.red.flag></x-button.red.flag>
                <x-button.blue.add-pic></x-button.blue.add-pic>
                <x-button.blue.clipboard-check></x-button.blue.clipboard-check>
                <x-button.blue.upload></x-button.blue.upload>
                <x-button.blue.leave></x-button.blue.leave>
                <x-button.blue.info></x-button.blue.info>
                <x-button.blue.question></x-button.blue.question>
                <x-button.blue.edit></x-button.blue.edit>
                <x-button.blue.settings></x-button.blue.settings>
                <x-button.blue.filter></x-button.blue.filter>
                <x-button.green.check></x-button.green.check>
                <x-button.green.award></x-button.green.award>
                <x-button.green.card></x-button.green.card>
                <x-button.green.pay></x-button.green.pay>
                <x-button.green.plus></x-button.green.plus>
                <x-button.green.send></x-button.green.send>
                <x-button.yellow.exclamation></x-button.yellow.exclamation>
                <x-button.border.filter></x-button.border.filter>
                <x-button.border.cart></x-button.border.cart>
                <x-button.none.filter></x-button.none.filter>
            </div>
        </div>
        <div class="my-2 pl-2 border border-black">
            <h1>Sans SVG</h1>
            <div class="flex p-2 gap-2">
                <x-button.red.empty>empty</x-button.red.empty>
                <x-button.blue.empty>empty</x-button.blue.empty>
                <x-button.green.empty>empty</x-button.green.empty>
                <x-button.yellow.empty>empty</x-button.yellow.empty>
                <x-button.border.empty>empty</x-button.border.empty>
                <x-button.none.empty>empty</x-button.none.empty>
            </div>
        </div>
        <div class="my-2 pl-2 border border-black">
            <h1>Vides</h1>
            <div class="flex p-2 gap-2">
                <x-button.red.empty></x-button.red.empty>
                <x-button.blue.empty></x-button.blue.empty>
                <x-button.green.empty></x-button.green.empty>
                <x-button.yellow.empty></x-button.yellow.empty>
                <x-button.border.empty></x-button.border.empty>
                <x-button.none.empty></x-button.none.empty>
            </div>
        </div>
    </div>
</x-app-layout>
