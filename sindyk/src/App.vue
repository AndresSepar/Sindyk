<template>
  <div id="app">
    <MainMenu v-if="status.load" />
    <HeroParallax v-if="status.load" />
    <GridPlans v-if="status.load" />
  </div>
</template>

<script>
import MainMenu from './components/MainMenu.vue'
import HeroParallax from './components/HeroParallax.vue'
import GridPlans from './components/GridPlans.vue'

export default {
  name: 'app',
  data () {
    return {
      status: {
        parse: false,
        load: false
      }
    }
  },
  mounted () {
    this.loadStructure()
    this.scrollEvent()
  },
  methods: {
    parseData () {
      var instance = this
      instance.$http.post('http://sindyk.test/api/parse').then(() => {
        instance.status.parse = true
        instance.loadStructure()
      })
    },
    loadStructure () {
      var instance = this
      instance.$http.get('http://sindyk.test/api/render').then((result) => {
        instance.$store.dispatch('addStructure', result.data)
        instance.status.load = true
      })
    },
    scrollEvent () {
      var instance = this
      var direction = {
        x: 0,
        y: 0
      }
      window.addEventListener('scroll', function () {
        var doc = document.documentElement
        var x = (window.pageXOffset || doc.scrollLeft)  - (doc.clientLeft || 0)
        var y = (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0)
        
        instance.$events.$emit('scrolling', {
          y: y,
          x: x,
          direction: {
            x: x > direction.x ? 'left' : 'right',
            y: y > direction.y ? 'up' : 'down',
          }
        })

        direction = {
          x: x,
          y: y
        }

      }, false)
    }
  },
  components: {
    MainMenu,
    HeroParallax,
    GridPlans
  }
}
</script>

<style lang="scss">
html, body {
  background: #f7f7f7;
  margin: 0;
  padding: 0;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;

  color: #2c3e50;
}
</style>
