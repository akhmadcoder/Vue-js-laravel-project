<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Harajatlar</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-block btn-primary" @click="newModal">Harajat Qo'shish
                  <i class="fas fa-plus-square fa-faw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Harajat turi</th>
                      <th>Summasi</th>
                      <th>To'lov turi</th>
                      <th>Qo'shimcha Ma'lumotlar</th>
                      <th>Sa'na</th>
                      <th>Soni</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="spending in spendings" :key="spending.id">
                      <td>{{spending.id}}</td>
                      <td>{{spending.expense.name}}</td>
                      <td>{{spending.cost}}</td>
                      <td>{{spending.money.name}}</td>
                      <td>{{spending.description}}</td>
                      <td>{{spending.date | myDate}}</td>
                      <td>{{spending.quantity}}</td>
                      <td>
                          <a href="#" @click="editModal(spending)">
                            <i class="fa fa-edit"></i>
                          </a>
                           | 
                          <a href="#" @click="deleteSpendings(spending.id)">
                            <i class="fa fa-trash" style="color:red"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

<!-- Modal -->
<div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-if="!editmode" class="modal-title" id="exampleModalLabel">Harajat Qo'shish</h5>
        <h5 v-if="editmode" class="modal-title" id="exampleModalLabel">Harajatni O'zgartirish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateSpendings() : createSpendings()">
      <div class="modal-body">
        <div class="form-group">
          <select v-model="form.expense_id" name="expense_id" id="expense_id" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('expense_id') }">
            <option value="">Harajat Turi</option>
            <option v-for="expense in expenses" :key="expense.id" :value="expense.id">{{expense.name}}</option>
          </select>
          <has-error :form="form" field="expense_id"></has-error>
        </div>

        <div class="form-group">
          <input v-model="form.cost" type="text" name="cost" 
            placeholder="Narxi"
            class="form-control" :class="{ 'is-invalid': form.errors.has('cost') }">
          <has-error :form="form" field="cost"></has-error>
        </div>

        <div class="form-group">
          <select v-model="form.money_id" name="money_id" id="money_id" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('money_id') }">
            <option value="">To'lov Turi</option>
            <option v-for="money in moneys" :key="money.id" :value="money.id">{{money.name}}</option>
          </select>
          <has-error :form="form" field="money_id"></has-error>
        </div>

        <div class="form-group">
          <input v-model="form.description" type="text" name="description" 
            placeholder="Qo'shimcha Ma'lumotlar"
            class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
          <has-error :form="form" field="description"></has-error>
        </div>

        <div v-if="!editmode" class="form-group">
          <input v-model="form.date" type="date" id="date" name="date" 
            placeholder="Sana"
            class="form-control" :class="{ 'is-invalid': form.errors.has('date') }">
          <has-error :form="form" field="date"></has-error>
        </div>
        
        <div v-if="editmode" class="form-group">
          <input v-model="form.date" type="text" id="date" name="date" 
            placeholder="Sana"
            class="form-control" :class="{ 'is-invalid': form.errors.has('date') }">
          <has-error :form="form" field="date"></has-error>
        </div>

        <div class="form-group">
          <input v-model="form.quantity" type="text" name="quantity" 
            placeholder="Soni"
            class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
          <has-error :form="form" field="quantity"></has-error>
        </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button v-if="!editmode" type="submit" class="btn btn-primary">Saqlash</button>
        <button v-if="editmode" type="submit" class="btn btn-primary">O'zgartirish</button>
      </div>
      </form>
    </div>
  </div>
</div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                editmode: false,
                spendings: {},
                expenses: {},
                moneys: {},
                form: new Form({
                    id: '',
                    expense_id: '',
                    cost: '',
                    money_id: '',
                    description: '',
                    date: '',
                    quantity: '',
                })


            }

        },

        methods:{

            deleteSpendings(id){
                swal.fire({
                    title: 'Ochirmoqchimisiz?',
                    text: "Ochirilgan narsa qayta tiklanmaydi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xa, ochir!'
                  }).then((result) => {

                    if(result.value){

                      // send request to the server
                      this.form.delete('api/spendings/'+id)
                      .then(function(response){

                        if(response.data.status === 'success')
                        {
                          Reload.$emit('ReloadContent')
                          swal.fire(
                            'Deleted!',
                            'Harajat muvaffaqiyatli ochirildi.',
                            'success'
                          )

                        }

                      })
                      .catch(()=>{

                          swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Qandaydir Xatolik Boldi!',
                          })

                      });

                    }
                  })

            },

            editModal(spending){
                this.editmode = true
                $('#addEditModal').modal('show')
                this.form.fill(spending)
            },

            updateSpendings(){
                this.form.put('api/spendings/'+this.form.id)
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent');
                      swal.fire(
                        'Updated!',
                        'Harajat Malumotlari muvaffaqiyatli ozgartirildi.',
                        'success'
                      )
                    }
                })
                .catch(()=>{

                    // if failed
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                    })
                })

            }, 

            createSpendings(){
                this.form.post('api/spendings')
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent')
                      swal.fire(
                        'Created!',
                        'Yangi Harajat qoshildi.',
                        'success'
                      )

                    }
                    
                })
                .catch(()=>{

                    // if failed
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                    })
                })

            },

            loadSpendings(){
                axios.get('api/spendings')
                .then(({ data }) => (
                    this.spendings = data.spendings,
                    this.expenses = data.expenses,
                    this.moneys = data.moneys
                ))
                .catch(()=>{

                    // if failed
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                    })
                });

            },

            newModal(){
                this.editmode = false
                $('#addEditModal').modal('show')
                this.form.reset()
            },

        },

        mounted() {
            this.loadSpendings()

            Reload.$on('ReloadContent', () => {
                this.loadSpendings();
            });
        }
    }
</script>
