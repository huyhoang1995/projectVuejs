<template>
<div class="modal fade" role="dialog" :id="id">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chi tiết</h4>
            </div>
            <div class="modal-body">
                <form data-parsley-validate class="form-horizontal" :id="formId">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên: </label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" v-model="data.name" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tuổi: </label>
                        <div class="col-sm-8">
                            <input class="form-control" type="number" v-model="data.age"  min="1" max="80" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Địa chỉ: </label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" v-model="data.address" required/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="update()">Cập nhật</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>

    </div>
</div>
</template>

<script>
const SingleExampleModal = {
    props: ['id', 'exampleData', 'retFunc'],
    created: function(){
        var tmpThis = this;
        this.$watch('exampleData', function(newVal, oldVal){
            tmpThis.data = Object.assign({}, newVal);
        })
    },
    data: function () {
        return {
            formId: myFunc.uniqueId(this.id),
            data: {}
        }
    },
    methods: {
        update: function () {
            if ($('#' + this.formId).parsley().validate()) {
                let param = service.exampleService.data.update(
                    this.data.name,
                    this.data.age,
                    this.data.address
                );
                let tmpThis = this;
                if (this.data.id > 0) { //thuc hien update
                    service.exampleService.action.update(this.data.id, param).then((respData) => {
                        console.log(respData);
                        tmpThis.retFunc();
                    }).catch(function (err) {
                        console.log(err);
                    });
                } else { //thuc hien insert
                    service.exampleService.action.insert(param).then((respData) => {
                        console.log(respData);
                        tmpThis.retFunc();
                    }).catch(function (err) {
                        console.log(err);
                    });
                }

            }
        }
    }
}
export default SingleExampleModal;
</script>
