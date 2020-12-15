<template>
  <div class="container  my-5">
      <div class="col-md-8 offset-md-4">
        <div class="row">
        <div class="col-md-4 mb-3">
          <button class="btn btn-success">Create</button>
        </div>
          <form class="col-md-8">
            <div class="input-group mb-3">
              <input type="text" class="form-control rounded-0" placeholder="Search Products">
              <span class="input-group-text rounded-0">Search</span>
            </div>

          </form>
      </div>
    </div>
    <div class="row">
      <!-- Create And Edit Form -->
      <div class="col-md-4">
        <div class="card">
          <h4 class="card-header">
            Create Product
          </h4>
          <div class="card-body">
            <form>
              <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control rounded-0" name="name">
              </div>
              <div class="mb-3">
                <label>Price</label>
                <input type="number" class="form-control rounded-0" name="price">
              </div>
              <button class="btn btn-success">Save</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Show All Data -->
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th colspan="2" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products">
                <th scope="row">{{ product.id }}</th>
                <td>{{ product.name }}</td>
                <td>{{ product.price }}$</td>
                <td class="text-center">
                  <button class="btn btn-info">Edit</button>
                </td>
                <td class="text-center">
                  <button class="btn btn-danger">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript" charset="utf-8">
  export default {
    name: 'ProductComponent',
    data() {
      return {
        products: []
      }
    },
    created() {
      axios.get('/api/products')
      .then(response=> {
        this.products = response.data;
      })
    }
  }
  </script>