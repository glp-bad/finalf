<template>


    <my-button @click="myMethodTest"
               :widthButton=300
    >Test de click pe butonul meu</my-button>

    <br>
    <br>

    <my-button @click="onClickWarnning">windows warnning</my-button>&nbsp;
    <my-button @click="onClickYesNo">windows yesno</my-button>&nbsp;
    <my-button @click="onClickInfo">windows info</my-button>&nbsp;
    <my-button @click="onClickRedAlert">windows redAlert</my-button>&nbsp;
    <my-button @click="onClickCheck">windows check</my-button>&nbsp;
    <my-button @click="onClickRedSkull">windows red-skull</my-button>&nbsp;
    <my-button @click="onClickFormular">Formular</my-button>&nbsp;

    <my-icon :svgIconName="'angellist-brands'" />&nbsp;
    <my-icon :svgIconName="'apps_blue'" />

    <br>
    <br>

    <my-button>Text.......<font-awesome-icon :icon="['fas', 'search']" size="1x"/></my-button>&nbsp;

    <br>
    <br>

    <my-drop-down-search :pDataMethod="'local'"
                    :pUrlData="'searchTableTest'"
    ></my-drop-down-search>

    <br>
    <br>

    <my-textfield></my-textfield>

    <!-- "/img/angellist-brands.svg" -->

    <!-- <icon :urlSvg="'../../../src/assets/icons/apps_blue.svg'" /> -->





    <!-- <icon :urlSvg="'/img/angellist-brands.svg'" /> -->

    <my-alert-window ref="refWarnning"
                  :cWidth=400
                  :cHeight=200
                  :cTypeWindows=1
    ></my-alert-window>

    <my-alert-window ref="refYesNo"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=3
    ></my-alert-window>

    <my-alert-window ref="refInfo"
                  :cWidth=300
                  :cHeight=200
                  :cTypeWindows=2
    ></my-alert-window>


    <my-alert-window ref="refRedAlert"
                     :cWidth=350
                     :cHeight=200
                     :cTypeWindows=4
    ></my-alert-window>


    <my-alert-window ref="refCheck"
                     :cWidth=350
                     :cHeight=200
                     :cTypeWindows=5
    ></my-alert-window>


    <my-alert-window ref="refRedSkull"
                     :cWidth=200
                     :cHeight=200
                     :cTypeWindows=6
    ></my-alert-window>

    <my-test-form ref="refTestForm"></my-test-form>


</template>

<script>
    import Button from '@/components/base/Button.vue';
    import Icon from '@/components/base/Icon.vue';
    import AlertWindow from "@/components/base/AlertWindow.vue";
    import TestForm from "@/components/app/test/FormTest.vue";
    import DropDownSearch from "@/components/base/DropDownSearch.vue";
    import TextField from "@/components/base/TextField.vue";

    export default {
        name: "controale",
        components: {
            'my-icon': Icon,
            'my-button': Button,
            'my-alert-window' : AlertWindow,
	        'my-test-form': TestForm,
            'my-drop-down-search': DropDownSearch,
            'my-textfield': TextField
        },
        mounted() {
        },
        methods: {
            myMethodTest: function () {
                console.log('click pe butonul');
            },
	        onClickWarnning: function () {
		        this.$refs.refWarnning.setMessage("Atentie, datele tale sunt alterate !!!");
		        this.$refs.refWarnning.show();
	        },
	        onClickYesNo: function(){
		        this.$refs.refYesNo.setMessage("Esti sigur ca vrei sa stergi datele la care ai muncit asa de mult ?");
		        this.$refs.refYesNo.show();
            },
	        onClickInfo: function (){
		        this.$refs.refInfo.setMessage("Datele au fost salvate in sistem ?");
		        this.$refs.refInfo.show();
            },
	        onClickRedAlert: function () {
		        this.$refs.refRedAlert.setMessage("Alarma rosie !!! Alarma rosie !!!");
		        this.$refs.refRedAlert.show();
            },
	        onClickCheck: function () {
		        this.$refs.refCheck.setMessage("Verific (check) in aplicatie.");
		        this.$refs.refCheck.show();
	        },
	        onClickRedSkull: function () {
		        console.log('call de doua ori RedSkull !!!!');
		        this.$refs.refRedSkull.setMessage("Radiatii. <br> Moarte !!!");
		        this.$refs.refRedSkull.show();
	        },
	        onClickFormular: function () {
		        this.$refs.refTestForm.showForm();
            }

        }

    }
</script>

<style scoped>
</style>
