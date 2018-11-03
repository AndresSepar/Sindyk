<template>
  <div class="HeroParallax">
    <div class="HeroParallax-background" ref="background" :style="{ backgroundImage: 'url(' + structure.information.image + ')' }"></div>
    <section class="hero is-large">
      <div class="hero-body">
        <div class="HeroParallax-content container">
          <h1 class="HeroParallax-contentTitle">
            {{structure.information.title}}
          </h1>
          <h2 class="HeroParallax-contentDescription">
            {{structure.information.description}}
          </h2>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'HeroParallax',
  mounted () {
    var instance = this;
    instance.$events.$on('scrolling', function(payload){
      instance.parallax(payload)
    })
  },
  methods: {
    parallax (data) {
      var instance = this
      var transY = data.y * 0.5
      var transform = 'translateY('+transY+'px)'
      instance.$refs.background.style.transform = transform;
    }
  },
  computed: {
    structure () {
      return this.$store.getters.structure
    }
  }
}
</script>

<style scoped lang="scss">
  .HeroParallax {
    overflow: hidden;
    position: relative;
    text-align: center;
    &-background {
      background-size: cover;
      background-position: center;
      position: absolute;
      text-align: center;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      z-index: 0;
    }
    &-content {
      color: #fff;
    }
    &-contentTitle {
      font-size: 2rem;
      line-height: 90px;
      font-weight: 700;
      margin: 0;
      padding: 0;
    }
    &-contentDescription {
      font-size: 1.5rem;
      line-height: 30px;
      margin: 0;
      padding: 0;
    }
  }

  @media screen and (min-width: 769px), print {
    .hero.is-large .hero-body {
      padding-bottom: 12rem;
      padding-top: 12rem;
    }
    .HeroParallax-contentTitle {
      font-size: 4rem;
    }
  }
</style>
