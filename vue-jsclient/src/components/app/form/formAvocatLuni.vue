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

            <table class="ff-form-table">
                <tr>
                    <td class="label-left bold">
                        <label :for=this.cfgtime.FIELD_YEAR.id>{{this.cfgtime.FIELD_YEAR.caption}}</label></td>

                    <td class="control">
                        <input-field
                                :ref = this.cfgtime.FIELD_YEAR.ref
                                :pConfig = this.cfgtime.FIELD_YEAR
                        ></input-field>
                    </td>
                    <td class="control">
                        <div class="prime-button last-button">
                            &nbsp;
                            <my-button  :ref=this.cfgtime.REF_BUTTON_REFRESH @click="this.clickRefresMonthList" :heightButton=22 :buttonType=2 title="refresh lista" :style="this.cfgtime.ICON_REFRESH.colorStyle">
                                <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_REFRESH) size="1x" />
                            </my-button>
                        </div>
                    </td>
                </tr>
            </table>

            <br>


            <my-list
                :ref = this.cfgtime.LIST_MONTH.ref
                :pConfig = this.cfgtime.LIST_MONTH
                @emitCheckLunaInchisa = 'emitCheckLunaInchisa'
            ></my-list>

                <table class="ff-form-table">
                </table>

        </template>
        <template v-slot:slotButton>
            <div class="buttons">
                <my-button @click="this.addMonth" :heightButton=22 :buttonType=0 title="modific date partener">{{this.captionButton}}</my-button>
            </div>
        </template>


    </form-tab>
</template>

<script>
    import AlertWindow  from "@/components/base/AlertWindow.vue";
    import FormTab      from "@/components/base/FormTab.vue";
    import Button       from "@/components/base/Button";
    import Lista        from "@/components/base/Lista";
    import InputField       from "@/components/base/InputField.vue";


    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'my-button': Button,
            'my-list': Lista,
	        'input-field': InputField
        },
        name: "form-avocat-luni",
        created() {
            this.REF_FORM_LUNI = 'refFormLuni';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
                message: [],
                post: { idPk: null, field: {}, sqlAction: null},
                yearList: 2022
            };
            this.cfgtime = {
            	REF_BUTTON_REFRESH: 'refButtonRefresh',
	            ICON_REFRESH: this.$constComponent.ICON_REFRESH("green"),
            	FIELD_YEAR: this.cfgYearField(),
                LIST_MONTH : {
                    ref: 'refMonthList',
                    header: [
                        this.$constList.getHeader(1, 'Luna',  150,    'nLuna',       this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER ),
                        this.$constList.getHeader(2, 'Luna inchisa', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],

                    recordActionButon: [
                        // this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        this.$constList.getActionButton(9, 'luna inchisa', 'emitCheckLunaInchisa', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('lunaInchisa', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
                    ],
                    cfg: { urlData: 'monthList',
                           loadOnCreate: false,
                           filedNameForCheckBox: 'inchisa',
                           emitListRowSelection: 'emitListRowSelection',
                           headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
                           heightList: 350
                    }
                },
            };

        },
        emits: ['emitNewRecord'],
        mounted () {
	        this.$refs[this.cfgtime.FIELD_YEAR.ref].setValue(this.runtime.yearList);
        },
        methods: {
        	privateServerCheckMonth(){

                let msg = '';

        		if(this.runtime.post.field.checkValue){
			        msg = 'Blochez luna selectata ?'
                }else{
			        msg = 'Deblochez luna selectata ?'
                }


		        if(!this.runtime.sendDataToServer) {
			        this.$refs.refYesNo.setCaption("Luna in lucru");
			        this.$refs.refYesNo.setMessage(msg);
			        this.$refs.refYesNo.show();
		        }

		        if(this.runtime.sendDataToServer) {
			        this.runtime.sendDataToServer = false;

			        console.log(this.runtime.post);
		        }





            },
	        clickRefresMonthList: function(){
		        this.runtime.yearList = this.$refs[this.cfgtime.FIELD_YEAR.ref].getValue();
		        this.refreshListLuniInchise();
            },
        	refreshListLuniInchise: function(){
        	    this.$refs[this.cfgtime.LIST_MONTH.ref].showList(this.privateParamMonthList());
            },
            addMonth: function (){
            },
            validateForm: function () {
            },
            setModeForm: function (mode){
                this.runtime.mode = mode;
            },
	        emitCheckLunaInchisa: function (checkBoxControl){

		        this.runtime.post.idPk = checkBoxControl.getAttribute("idPk");



		        this.setPost({name: 'checkValue' }, checkBoxControl.checked);
		        this.setPost({name: 'control' }, checkBoxControl);          // only for rebuild control is no action

		        this.privateServerCheckMonth();
	        },
            emitYesNoButton: function (yes) {
                if(yes == 1){

	                this.runtime.post.field.control = null;     // nu mai avem nevoie de control checkbox

                    this.runtime.sendDataToServer = true;
                    this.privateServerCheckMonth();
                }else{
                    this.runtime.sendDataToServer = false;

                    //refac bifa
	                if(this.runtime.post.field.checkValue){
		                this.runtime.post.field.control.checked = false;
	                } else {
		                this.runtime.post.field.control.checked = true;
	                }

	                this.runtime.post.field.control = null;     // nu mai avem nevoie de control checkbox
                }
            },
            setPost: function (component, value){
                this.runtime.post['field'][component.name] = value;
            },
            privateParamMonthList: function (){
	            return {'yearList': this.runtime.yearList};
            },
	        cfgYearField: function(){
		        let cfg = this.$app.cfgInputField("year", 70, 40);
		        cfg.setValidate(4,4);
		        cfg.setValidateFunction(this.validateYear);
		        cfg.setCaption("Anul in lucru");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        },
        },
        data () {
            return {
                captionButton: 'Adaug luna'
            }
        }
    }

</script>

<style scoped></style>
