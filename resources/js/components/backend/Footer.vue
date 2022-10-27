<template>
  <footer class="main-footer">
    <div class="pull-right hidden-xs"><b>Developed by:</b>  {{$root.site?$root.site.developed_by:''}} </div>
    <strong>
      Copyright &copy; {{year}}
      <a href="#"> {{$root.site?$root.site.title:''}} </a>.
    </strong>
    All rights reserved.
  </footer>
</template>

<script>
export default {
  data(){
    return{
      year: new Date().getFullYear()
    }
  }
};
</script>

<style>
</style>