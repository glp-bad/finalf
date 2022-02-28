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

    <form-tab :ref = this.REF_FORM_LUNI>
        <template v-slot:slotTitle>
        </template>
        <template v-slot:slotContent>
            <my-list
                :ref = this.cfgtime.LIST_MONTH.ref
                :pConfig = this.cfgtime.LIST_MONTH
            ></my-list>

                <table class="ff-form-table">
                </table>

        </template>
        <template v-slot:slotButton>
            <div class="buttons">
                <my-button @click="this.editPartener" :heightButton=22 :buttonType=0 title="modific date partener">{{this.captionButton}}</my-button>
            </div>
        </template>


    </form-tab>
</template>

<script>
    import AlertWindow  from "@/components/base/AlertWindow.vue";
    import FormTab      from "@/components/base/FormTab.vue";
    import Button       from "@/components/base/Button";
    import Lista        from "@/components/base/Lista";


    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'my-button': Button,
            'my-list': Lista
        },
        name: "form-avocat-luni",
        created() {
            this.REF_FORM_LUNI = 'refFormLuni';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
                message: [],
                post: { idPk: null, field: {}, sqlAction: null}
            };
            this.cfgtime = {
                LIST_MONTH : {
                    ref: 'refMonthList',
                    header: [
                        this.$constList.getHeader(1, 'Luna',  150,    'nLuna',       this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER )
                        // this.$constList.getHeader(5, 'Action', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],

                    recordActionButon: [
                        // this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        // this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
                    ],
                    cfg: { urlData: 'monthList', loadOnCreate: true,
                           filedNameForCheckBox: 'activ',
                           emitListRowSelection: 'emitListRowSelection',
                           headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
                           heightList: 310
                    }
                },
            }
        },
        emits: ['emitNewRecord'],
        mounted () {
        },
        methods: {
            editPartener: function (){
            },
            validateForm: function () {
            },
            setModeForm: function (mode){
                this.runtime.mode = mode;
            },
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    // this.editServerDatePartener();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
            setPost: function (component, value){
                this.post['field'][component.name] = value;
            }
        },
        data () {
            return {
                captionButton: 'Adaug luna'
            }
        }
    }

</script>

<style scoped></style>
