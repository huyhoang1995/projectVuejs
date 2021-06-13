<template>
  <div class="modal fade" role="dialog" id="singleTodolistModel">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            &times;
          </button>
          <h4 class="modal-title">Chi tiết công việc</h4>
        </div>
        <div class="modal-body">
          <form data-parsley-validate class="form-horizontal" :id="formId">
            <div class="form-group">
              <label class="col-sm-3 control-label">Tên: </label>
              <div class="col-sm-8">
                <input
                  class="form-control"
                  type="text"
                  v-model="data.name"
                  required
                />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Mô tả: </label>
              <div class="col-sm-8">
                <textarea
                  class="form-control"
                  type="text"
                  v-model="data.description"
                  required
                >
                </textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Hạn chót: </label>
              <div class="col-sm-3">
                <input
                  class="form-control"
                  type="text"
                  v-model="data.due_date"
                  required
                />
              </div>
              <label class="col-sm-2 control-label">Mức độ: </label>
              <div class="col-sm-3">
                <select
                  name=""
                  id="input"
                  class="form-control"
                  v-model="data.plority"
                  required="required"
                >
                  <option value="low">Thấp</option>
                  <option value="normal">Trung bình</option>
                  <option value="high">Cao</option>
                </select>
              </div>
            </div>
            <div class="form-group" v-if="data.id > 0">
              <label class="col-sm-3 control-label"> Hoàn thành </label>
              <div class="col-sm-3">
                <input
                  class=""
                  type="checkbox"
                  v-model="data.is_done"
                  required
                />
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" @click="update()">
            Cập nhật
          </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">
            Đóng
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const SingleExampleModal = {
  props: ["todolistData", "retFunc"],
  created: function () {
    var tmpThis = this;
    this.$watch("todolistData", function (newVal, oldVal) {
      console.log(newVal);
      tmpThis.data = Object.assign({}, newVal);
      if (tmpThis.data.is_done == 1) {
        tmpThis.data.is_done = true;
      } else {
        tmpThis.data.is_done = false;
      }
    });
  },
  data: function () {
    return {
      formId: myFunc.uniqueId(this.id),
      data: {},
    };
  },
  methods: {
    update: function () {
      if (
        $("#" + this.formId)
          .parsley()
          .validate()
      ) {
        let tmpThis = this;
        if (this.data.id > 0) {
          //thuc hien update
          var params = {
            name: this.data.name,
            description: this.data.description,
            due_date: this.data.due_date,
            plority: this.data.plority,
            is_done: this.data.is_done,
          };
          service.todolistService.action
            .updateTodoList(this.data.id, params)
            .then((respData) => {
              console.log(respData);
              tmpThis.retFunc();
            })
            .catch(function (err) {
              console.log(err);
            });
        } else {
          //thuc hien insert

          var params = {
            name: this.data.name,
            description: this.data.description,
            due_date: this.data.due_date,
            plority: this.data.plority,
          };
          service.todolistService.action
            .createTodoList(params)
            .then((respData) => {
              console.log(respData);
              tmpThis.retFunc();
            })
            .catch(function (err) {
              console.log(err);
            });
        }
      }
    },
  },
};
export default SingleExampleModal;
</script>
