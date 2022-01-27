<template>
    <div class="ff-workbench" ref="refWorkBench">
        <tab-parteneri ref="refTab"
            :pConfig=this.tabConfig
            @emitClickTab="emitClickTab"
        >
            <template v-slot:tabs>
                <div class="tab" :id="this.$constTab.getIdTab('1p')">
                    <div class="up-line"></div>
                    <grid-parteneri ref="gridParteneri"
                             :pConfig=this.gridConfig
                              @emitSelectDataOnGrid = "emitSelectDataOnGrid"
                    ></grid-parteneri>
                </div>
                <div class="tab" :id="this.$constTab.getIdTab('2p')">
                    <div class="up-line"></div>
                    <div class="title-continut-tab">{{this.tabs.tab02.captionForm}}</div>
                    <form-partener ref="refPartenerEdit"></form-partener>
                </div>
            </template>
        </tab-parteneri>

    </div>
</template>

<script>
    import Tab from "@/components/base/Tab";
    import Gridul from '@/components/base/Gridul';
    import formPartener from '@/components/app/form/formPartener';

    export default {
		components: {
            'tab-parteneri': Tab,
            'grid-parteneri': Gridul,
            'form-partener': formPartener
        },
		name: "view-parteneri",
		created() {
		    this.REF_PARTENER_EDIT = 'refPartenerEdit',
		    this.TAB_EDIT = {id: '2p', urlGetDate: this.$url.getUrl('partenerGetData')},
            this.tabConfig = {
                header: [
                    this.$constTab.getHeader('1p','Parteneri'),
                    this.$constTab.getHeader('2p','Editare date partener'),
                ],
                defaultTabId: '1p',
                tabsWidth: '1040px'
            },
            this.gridConfig = {
                    header: [
                        this.$constGrid.HEADER.getHeader(1,'Nume',450,'cNume', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, true, true, null),
                        this.$constGrid.HEADER.getHeader(2,'Organizare',180,'cTipAbrev', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, true, true, 't_tip_organizare_juridica.cTipAbrev'),
                        this.$constGrid.HEADER.getHeader(3,'Registrul comertului',180,'regcom', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, false, true, null),
                        this.$constGrid.HEADER.getHeader(4,'RO',70,'ro_', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, false, false, true, null),
                        this.$constGrid.HEADER.getHeader(5,'Cui',100,'cui', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, false, false, true, null)


                    ],
                    actionButtonHeader: [
                        //this.$constGrid.getActionButton(7, 'Altceva din functie', 'altCeca', this.$constGrid.getIcon('fas','skull', '#adad00')),
                        // this.$constGrid.getActionButton(8, 'Print din functie', 'invoicePrint', this.$constGrid.ICON_PRINT)
                        //this.$constGrid.getActionButton(9, 'Edit din functie', 'deleteCeva', this.$constGrid.ICON_DELETE),
                        //this.$constGrid.getActionButton(10, 'Delete din functie', 'editCeva', this.$constGrid.ICON_EDIT)
                    ],
                    returnField: ['cNume'],             // return field and edit when selected row
                    cfg: {
                        width: 1100,
                        height: 500,
                        urlData: 'gridListParteneri'
                    },
                    toolbar: {
                        show: true,
                        fieldShow: {
                            field: ['cNume'],        // shon on selection with mouse or keyboard
                            separator: " ",
                            includeIdPk: true
                        },
                        actionButton : [
                            // this.$constGrid.getActionButton( null,  'Print din functie', 'invoicePrintToolbar', this.$constGrid.ICON_PRINT),
                            // this.$constGrid.getActionButton( null,  'Edit din functie',   'deleteCevaToolbar', this.$constGrid.ICON_DELETE),
                            // this.$constGrid.getActionButton( null,  'Delete din functie', 'editCevaToolbar', this.$constGrid.ICON_EDIT)
                        ]
                    },
                    emitSelectData: 'emitSelectDataOnGrid',
                    paginate: {
                        nrButtonShow: 10,
                        recordsPerPage: 21
                    }
                }
		},
        mounted () {
		    this.$refs.refTab.goToTab(this.tabConfig.defaultTabId);
            this.$refs.refTab.tabOnOff('2p','off');
        },
		methods: {
		    emitClickTab: function (idTab) {
		        if(idTab == this.TAB_EDIT.id){
                    this.getDataFromServer(this.TAB_EDIT.urlGetDate, idTab);
                }
            },
            emitSelectDataOnGrid: function (selectData) {
		        let onOff = 'on';
		        let title = null;
		        if(this.$check.isUndef(selectData)){
                    onOff = 'off';
                    this.post.idPk = -1;
                }else{
                    title = selectData.cNume;
                    this.post.idPk = selectData.idPk;
                }
                this.$refs.refTab.tabOnOff('2p', onOff);
		        // edit tab
                this.tabs.tab02.captionForm = title;
            },
            getDataFromServer: function ($url, idTab) {
                this.showModalLoadingDiv = true;
                this.axios
                    .post($url, this.post)
                    .then(response => {
                        this.showModalLoadingDiv = true;
                        this.responseData = response.data;
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.showModalLoadingDiv = false;

                        if(idTab == this.TAB_EDIT.id) {
                            this.$refs[this.REF_PARTENER_EDIT].fillForm(this.responseData.records);
                        }

                    });

            },
		},
		data () {
			return {
			    responseData: null,
                showModalLoadingDiv: true,
                post: { idPk: null},
			    tabs:{
			        tab01: {},
                    tab02: {captionForm: null, selectData: null}
                }
            }
		}
	}

</script>

<style scoped></style>
