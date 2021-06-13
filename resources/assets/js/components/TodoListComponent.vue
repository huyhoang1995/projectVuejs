<template>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Test VueJS <button class="btn btn-success" @click="showSingleModal()">Thêm mới</button></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Name</th>
                        <th>Thời gian</th>
                        <th>Mức độ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in listExmaple" :key="key">
                        <td>{{ showOrder(key) }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.due_date }}</td>
                        <td>{{ item.plority }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-danger" @click="deleteExample(item.id)">Xóa</a>
                            <a v-if="item.is_done == 0" href="javascript:void(0)" class="btn btn-primary" @click="doneTodoList(item.id)">Hoàn thành</a>
                            <a href="javascript:void(0)" class="btn btn-default" @click="showSingleModal(item)">Cập nhật</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <pagination :pagination="filter.pagination" :callback="loadData" :options="filter.paginationOptions"></pagination>
            </div>
        </div>
    </div>
    <!-- <single-example-modal :id="singleModal.id" :example-data="singleModal.data" :ret-func="successFunc"></single-example-modal> -->
    <single-todo-list-model :todolist-data="singleModal.data" :ret-func="successFunc" ></single-todo-list-model>
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
                    per_page: 10, // required
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
            $("#singleTodolistModel").modal("hide");
            myNotify.success("Cập nhật thành công");
            this.loadData();
        },
        showSingleModal: function (item) {
            if (item) {
                this.singleModal.data = item;
            }
            $("#singleTodolistModel").modal("show");
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
            var param = {
                perPage :this.filter.pagination.per_page
            }; 
            service.todolistService.action.getTodolist(param).then(respData => {
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
            myBootbox.confirm("Bạn có muốn xóa công việc này không", function (result) {
                if (result) {
                    service.todolistService.action.deleteTodolist(id).then(() => {
                        myNotify.success("Xóa thành công");
                        tmpThis.loadData();
                    }).catch((err) => {
                        console.log(err);
                        myNotify.err("Xóa thất bại");
                    });
                }
            });

        },
        doneTodoList: function (id) {
            var tmpThis = this;
            myBootbox.confirm("Bạn có muốn hoàn thành công việc này không", function (result) {
                if (result) {
                    service.todolistService.action.doneTodoList(id).then(() => {
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
        singleExampleModal: require("@component/modal/SingleExampleModal.vue"),
        singleTodoListModel: require("@component/modal/SingleTodoListModel.vue")
    }
}
</script>
