<template>
  <div v-if="products.length > 0" v-for="product in products" :key="product.id"  class="card mb-3" style="width: 18rem; float:left; margin-left:10px">
    <h3 class="card-header ellipsis">{{ product.name }}</h3>
    <div class="card-body">
      <h6 class="card-subtitle text-muted" style="width: 10rem; float:left">{{ product.category_name }}</h6>
      <button type="button" class="btn btn-info disabled" style="background-color:#007bff;float:right">{{ product.price }} $</button>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-block user-select-none" width="100%" height="200" aria-label="Placeholder: Image cap" focusable="false" role="img" preserveAspectRatio="xMidYMid slice" viewBox="0 0 318 180" style="font-size:1.125rem;text-anchor:middle">
      <rect width="100%" height="100%" fill="#868e96"></rect>
      <text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text>
    </svg>
    <div class="card-body">
      <p class="card-text ellipsis" style="height: 4.3rem;">{{ product.description }}</p>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Weight: {{ product.weight }}</li>
      <li class="list-group-item">Length: {{ product.length }}</li>
      <li class="list-group-item">Width: {{ product.width }}</li>
    </ul>
    <div class="card-body">
      <a href="#" class="card-link">Card link</a>
      <a href="#" class="card-link">Another link</a>
    </div>
    <div class="card-footer text-muted">
      2 days ago
    </div>
  </div>
  <div v-else class="card border-primary mb-3" style="max-width: 20rem; text-align: center; margin:auto">
      <div class="card-body">
        <h4 class="card-title">No results</h4>
        <p class="card-text">Try to change your conditions</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {

  props: [
    'api_url'
  ],
  data() {
    return {
      products: [],
      catsMock: [],
      weightMock: [],
      lengthMock: [],
      widthMock: [],
    };
  },
  computed: {
    categories() {
      const categories = [];
      for (const product of this.products) {
        let current = {}
        current['id'] = product.category_id
        current['name'] = product.category_name
        const hasValue = categories.some(item => item.id === product.category_id)
        if (!hasValue) {
          categories.push(current)
        }        
      }
      return (categories.length > this.catsMock.length) ? categories : this.catsMock;
    },
    weights() {
      const weights = [];
      for (const product of this.products) {
        if (!weights.includes(product.weight) && product.weight !== null) {
          weights.push(product.weight)
        }
      }
      return (weights.length > this.weightMock.length) ? weights.sort() : this.weightMock;
    },
    lengths() {
      const lengths = [];
      for (const product of this.products) {
        if (!lengths.includes(product.length) && product.length !== null) {
          lengths.push(product.length)
        }
      }
      return (lengths.length > this.lengthMock.length) ? lengths.sort() : this.lengthMock;
    },
    widths() {
      const widths = [];
      for (const product of this.products) {
        if (!widths.includes(product.width) && product.width !== null) {
          widths.push(product.width)
        }
      }
      return (widths.length > this.widthMock.length) ? widths.sort() : this.widthMock;
    },
  },
  watch: {
    api_url: {
      handler(){
        axios.get(this.api_url)
        .then(res => {
          this.products = res.data.data
          this.$emit('categories', this.categories)
          this.$emit('weights', this.weights)
          this.$emit('lengths', this.lengths)
          this.$emit('widths', this.widths)
        })
        .catch(error => {
          console.log(error)
          // Manage errors if found any
        })
      },
      immediate: true
    },
    categories(newValue) {
      this.catsMock = newValue
    },
    weights(newValue) {
      this.weightMock = newValue
    },
    lengths(newValue) {
      this.lengthMock = newValue
    },
    widths(newValue) {
      this.widthMock = newValue
    },
  }
};
</script>

<style>
.ellipsis {
  height: 7rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>