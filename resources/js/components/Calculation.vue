<template>
    <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Kalkulyatsiya</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 600px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Maxsulot</th>
                      <th>Turi</th>
                      <th>Tarkibi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="product in products" :key="product.id">
                      <td>{{product.id}}</td>
                      <td>{{product.name}}</td>
                      <td>{{product.producttypes.name}}</td>
                      <td>
                        <a @click="loadRawMaterials(product)" href="#"><i class="fas fa-server"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Maxsulot Nomi: {{this.productName}}</h3>

              </div>

              <div class="card-header">
              <form @submit.prevent="addRawMaterial()">
                <div class="row">
                      <div class="col-6">
                        <select v-model="form.raw_materials_id" name="raw_materials_id" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('raw_materials_id') }">
                            <option value="">Xom Ashyo</option>
                            <option v-for="rawMaterial in rawMaterials" :key="rawMaterial.id" :value="rawMaterial.id">{{rawMaterial.name}}</option>
                          </select>
                          <has-error :form="form" field="raw_materials_id"></has-error>
                      </div>
                      <div class="col-3">
                        <input v-model="form.quantity" type="text" name="quantity" 
                            placeholder="Soni"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                          <has-error :form="form" field="quantity"></has-error>
                      </div>
                      <div class="col-3">
                        <button type="submit" class="btn btn-block btn-primary">Qo'shish</button>
                      </div>
                </div>
               </form>

              </div>

              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Tarkibi</th>
                      <th>Soni</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="singleRawMaterial in singleRawMaterials" :key="singleRawMaterial.id">
                      <td>{{singleRawMaterial.id}}</td>
                      <td>{{singleRawMaterial.rawmaterials.name}}</td>
                      <td>{{singleRawMaterial.quantity}}</td>
                      <td>
                        <a href="#" @click="deleteRawMaterial(singleRawMaterial.id)">
                            <i class="fa fa-trash" style="color:red"></i>
                        </a>
                      </td>
                      <td></td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                products: {},
                productName: '',
                rawMaterials: {},
                singleRawMaterials: {},
                form: new Form({
                    id: '',
                    quantity: '',
                    raw_materials_id: '',
                    product_id: '',
                })

            }

        },

        methods:{

            deleteRawMaterial(id){
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
                      this.form.delete('api/calculation/'+id)
                      .then(function(response){

                        if(response.data.status === 'success')
                        {
                          Reload.$emit('ReloadContent')
                          swal.fire(
                            'Deleted!',
                            'Maxsulot muvaffaqiyatli ochirildi.',
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

            addRawMaterial(){
                this.form.post('api/calculation')
                .then(function(response){

                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent');
                      swal.fire(
                        'Created!',
                        'Yangi Maxsulot qoshildi.',
                        'success'
                      )
                    }

                    if(response.data.status === 'error')
                    {
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Ushbu Xom Ashyo Allaqachon Qoshilgan',
                        })
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

            loadRawMaterials(product){
                this.form.product_id = product.id
                this.productName = product.name
                Reload.$emit('ReloadContent');
                this.form.quantity = ""
                this.form.raw_materials_id = ""
            },

            loadSingleRowMaterials(){
                axios.get('api/singlerowmaterials/'+this.form.product_id)
                    .then(({ data }) => (
                        this.singleRawMaterials = data.materials
                    ))
                    .catch(()=>{

                        // if failed
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Qandaydir Xatolik Boldi!',
                        })
                    });
                this.form.quantity = ""
                this.form.raw_materials_id = ""

            },

            loadProducts(){
                axios.get('api/calculation')
                    .then(({ data }) => (
                        this.products = data.products,
                        this.rawMaterials = data.rawMaterials
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

        },
        mounted() {
            this.loadProducts()

            Reload.$on('ReloadContent', () => {
                this.loadSingleRowMaterials();
            });

        }
    }
</script>
