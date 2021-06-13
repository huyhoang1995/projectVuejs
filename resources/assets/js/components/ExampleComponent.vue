<template>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Test VueJS <button class="btn btn-success" @click="showSingleModal()"><i class="fa fa-plus"></i> Thêm mới</button></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in listExmaple" :key="key">
                        <td>{{ showOrder(key) }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.age }}</td>
                        <td>{{ item.address }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-danger" @click="deleteExample(item.id)"><i class="fa fa-trash"></i></a>
                            <a href="javascript:void(0)" class="btn btn-default" @click="showSingleModal(item)"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <pagination :pagination="filter.pagination" :callback="loadData" :options="filter.paginationOptions"></pagination>
            </div>
        </div>
    </div>
    <single-example-modal :id="singleModal.id" :example-data="singleModal.data" :ret-func="successFunc"></single-example-modal>
</div>
</template>

<script>
export default {
    mounted() {
        this.loadData();
    },
    data: function () {
        return {
            listExmaple: [],
            filter: {
                pagination: {
                    total: 0,
                    per_page: 5, // required
                    current_page: 1, // required
                    last_page: 0, // required
                    from: 1,
                    to: 1
                },
                paginationOptions: {
                    offset: 4,
                    previousText: "<",
                    nextText: ">",
                    alwaysShowPrevNext: true
                },
                freeText: ""
            },
            singleModal: {
                id: "singleExampleModal",
                data: {
                    id: 0,
                    name: "",
                    age: 0,
                    address: ""
                }
            }
        }
    },
    methods: {
        successFunc: function () {
            $("#" + this.singleModal.id).modal("hide");
            myNotify.success("Cập nhật thành công");
            this.loadData();
        },
        showSingleModal: function (item) {
            this.singleModal.data = (item) ? item : this.resetSingleData();
            $("#" + this.singleModal.id).modal("show");
        },
        resetSingleData: function(){
            return {
                id: 0,
                name: "",
                age: 0,
                address: ""
            }
        },
        showOrder: function (index) {
            return (index + 1 + (this.filter.pagination.current_page - 1) * this.filter.pagination.per_page);
        },
        loadData: function () {
            var tmpThis = this;
            var param = service.exampleService.data.list(this.filter.freeText, this.filter.pagination.current_page, this.filter.pagination.per_page);
            service.exampleService.action.list(param).then(respData => {
                tmpThis.listExmaple = respData.data.data;

                tmpThis.filter.pagination.total = respData.data.total;
                tmpThis.filter.pagination.from = respData.data.from;
                tmpThis.filter.pagination.to = respData.data.to;
                tmpThis.filter.pagination.last_page = respData.data.last_page;
            }).catch(err => {
                console.log(err);
            });
        },
        deleteExample: function (id) {
            var tmpThis = this;
            myBootbox.confirm("Bạn có muốn xóa chuyên mục này không", function (result) {
                if (result) {
                    service.exampleService.action.delete(id).then(() => {
                        myNotify.success("Xóa thành công");
                        tmpThis.loadData();
                    }).catch((err) => {
                        console.log(err);
                        myNotify.err("Xóa thất bại");
                    });
                }
            });

        }
    },
    components: {
        singleExampleModal: require("@component/modal/SingleExampleModal.vue")
    }
}
</script>
