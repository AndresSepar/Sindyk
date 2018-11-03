<template>
  <div>
    <nav ref="menuDesktop" class="MainMenu navbar is-fixed-top is-transparent" role="navigation" aria-label="main navigation">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" :href="structure.information.url">
            <img class="MainMenu-light" :src="structure.information.logo_light">
            <img class="MainMenu-dark" :src="structure.information.logo_dark">
          </a>

          <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasic" @click="menuIsActive = !menuIsActive">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>

        <div id="navbarBasic" class="navbar-menu">
          <div class="navbar-end">
            <TreeMenu v-if="structure.menu.length" :data="structure.menu"/>
          </div>
        </div>
      </div>
    </nav>
    <transition name="slither">
      <div ref="menuMobile" class="MainMenuMobile" v-if="menuIsActive">
        <a class="MainMenuMobile-close" @click="menuIsActive = !menuIsActive"></a>
        <div class="MainMenuMobile-box">
          <TreeMenu v-if="structure.menu.length" :data="structure.menu" mode="vertical"/>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import TreeMenu from './TreeMenu.vue'
export default {
  name: 'MainMenu',
  data () {
    return {
      menuIsActive: false
    }
  },
  mounted () {
    var instance = this
    instance.$events.$on('scrolling', function(payload){
      instance.moving(payload)
    })
  },
  methods: {
    moving (data) {
      var instance = this
      var classes = instance.$refs.menuDesktop.classList

      if (data.direction.y == 'down') {
        classes.remove('MainMenu-up')
        classes.add('MainMenu-down')
        if (data.y == 0) {
          classes.remove('MainMenu-down', 'MainMenu-up')
        }
      } else {
        classes.remove('MainMenu-down')
        classes.add('MainMenu-up')
      }
    },
    menuToggle () {

    }
  },
  computed: {
    structure () {
      return this.$store.getters.structure
    }
  },
  components: {
    TreeMenu
  }
}
</script>

<style scoped lang="scss">
  .MainMenu {
    background: none;
    color: #fff;
    transition: all 600ms cubic-bezier(0.39, 0.575, 0.565, 1);
    transition-property: transform, background;
    z-index: 1;
    &-down {
      background: #fff;
      color: #333;
    }
    &-up {
      transform: translateY(-100px);
    }
    &-light,
    &-dark {
      max-height: 48px;
    }
    &-dark {
      display: none;
    }
  }
  .MainMenu.navbar .navbar-burger {
    color: whitesmoke;
  }
  .MainMenu.navbar.MainMenu-down .navbar-burger {
    color: #36b347;
  }
  .MainMenu-up {
    .MainMenu-light {
      display: block;
    }
    .MainMenu-dark {
      display: none;
    }
  }
  .MainMenu-down {
    .MainMenu-light {
      display: none;
    }
    .MainMenu-dark {
      display: block;
    }
  }

  /* MainMenuMobile */
  .MainMenuMobile {
    background-color: #36b347;
    width: 340px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 31;
    &-close {
      color: whitesmoke;
      cursor: pointer;
      display: block;
      font-size: 48px;
      font-weight: lighter;
      height: 48px;
      position: relative;
      text-align: center;
      width: 48px;
      margin-left: auto;
      &:after {
        content: "×";
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
    }
    &-box {
      position: absolute;
      top: 70px;
      right: 40px;
      bottom: 100px;
      left: 40px;
    }
    @media (min-width: 1088px) {
      display: none;
    }
  }

  .slither-enter-active,
  .slither-leave-active {
    transition: transform .3s;
  }
  .slither-enter,
  .slither-leave-to {
    transform: translateX(100%);
  }
  .slither-enter-to,
  .slither-leave {
    transform: translateX(0%);
  }
</style>
