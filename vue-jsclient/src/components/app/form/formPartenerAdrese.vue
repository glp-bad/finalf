<template>
    <validate-window ref="validateWindowRef"
                     :cWidth=500
                     :cHeight=200
                     :cTypeWindows=1
    ></validate-window>

    <validate-window ref="infoWindowRef"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=5
    ></validate-window>

    <validate-window ref="redWindowRef"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=6
    ></validate-window>

    <validate-window ref="refYesNo"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButton"
    ></validate-window>

    <form-tab :ref = this.REF_FROM>
        <template v-slot:slotTitle>
            <div class="antet">
                <div class="buttons-container">
                    <div class="prime-button last-button">
                        <my-button  :ref=this.REF_BUTTON_ADD_ADRESS @click="this.setFormNewAdress" :heightButton=22 :buttonType=2 title="adaug adresa noua" :style="this.ICON_ADD_PARTENER.colorStyle">
                            <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.ICON_ADD_PARTENER) size="1x" />
                        </my-button>
                    </div>
                </div>
                <div class="title">{{this.titleForm}}</div>
            </div>
        </template>
        <template v-slot:slotContent>
            <my-list-adress
                :ref = this.REF_LISTA_ADRESE
                :pConfig=this.cfgListaAdresaConfig
                @emitAdresaImplicita = "emitAdresaImplicita"
            ></my-list-adress>
        </template>

        <template v-slot:slotButton>
        </template>

    </form-tab>
</template>

<script>
    import AlertWindow from "@/components/base/AlertWindow.vue";
    import FormTab from "@/components/base/FormTab.vue";
    import InputField from "@/components/base/InputField.vue";
    import DropDownSimple from "@/components/base/DropDownSimple.vue";
    import CheckBox from "@/components/base/CheckBox.vue";
    import Button from "@/components/base/Button";
    import Lista        from "@/components/base/Lista";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'input-field': InputField,
            'type-partener': DropDownSimple,
            'check-box': CheckBox,
            'my-button': Button,
            'my-list-adress': Lista
        },
        name: "form-partener-adrese",
        created() {
            this.REF_FROM = 'refForm';
            this.REF_BUTTON_ADD_ADRESS = 'refButtonAddAdress';
            this.REF_LISTA_ADRESE = 'refListaAdresa';
            this.ICON_ADD_PARTENER =  this.$constComponent.ICON_ADD_PERSON("blue");
            this.cfgListaAdresaConfig = {
                header: [
                    this.$constList.getHeader(1, 'Adresa', 200, 'cAdresa', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                    this.$constList.getHeader(2, 'Localitate', 200, 'localitate', this.$constList.HEADER.CAPTION_TYPE_FIELD ),
                    this.$constList.getHeader(3, 'Adresa implicita', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                ],
                recordActionButon: [
                    // this.$constList.getActionButton(4, 'adresa implicita', 'emitButton', this.$constGrid.getIcon('fas','skull', '#adad00'), this.$constList.ACTION_BUTTON.TYPE_BUTTON, null),
                    this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false))   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                    // this.$constList.getActionButton(4, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00')),
                ],
                cfg: { urlData: 'partenerAdressList', loadOnCreate: false, filedNameForCheckBox: 'activ'}
            },
            this.runtime = {
                sendDataToServer: false,
                idPartner: -1,
                post: { idPk: null, field: {}, sqlAction: null}
            };
            this.cfgtime = {
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
        },
        methods: {
            showList: function (postData){
                  this.$refs[this.REF_LISTA_ADRESE].showList(postData);
            },
            serverGetDataList: function (idPk) {
            },
            serverCheckAdress: function (){
            },
            setFormNewAdress: function (){
            },
            emitAdresaImplicita: function (checkBoxControl){
                // this.postAdress.idPk = checkBoxControl.getAttribute("idPk");
                if(!checkBoxControl.checked){
                    // este deja bifat, nu fac nimic, refac bifa;
                    checkBoxControl.checked = true;
                }else{
                    console.log('intreba daca vrea sa devina addresa implicita');
                    checkBoxControl.checked = false;
                    // this.setAdressActive();
                }

            },
            validateForm: function () {
            },
            resetfillForm: function () {
                this.titleForm = "...";
            },
            fillForm: function () {
            },
            setIdAndTitle: function (title, idPk){
              this.runtime.idPartner = idPk;
              this.titleForm =  title;
            },
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
            setPost: function (component, value){
            },
            setPostAction: function (value){
            }
        },
        data () {
            return {
                form: {message: []},
                titleForm: 'titlu programing time ... '
            }
        }
    }

</script>

<style scoped></style>
