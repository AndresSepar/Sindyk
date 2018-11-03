<template>
  <ul class="TreeMenu" :class="'TreeMenu--'+mode">
    <li v-for="item in data" :key="item.id">
      <a :href="item.url" :class="{hasChildren: item.children && item.children.length}" @click="toggle($event, item.children && item.children.length)">
        {{item.label}}
        <i v-if="item.children && item.children.length" class="arrow"></i>
      </a>
      <TreeMenu v-if="item.children && item.children.length" :data="item.children" :mode="mode"/>
    </li>
  </ul>
</template>

<script>
import TreeMenu from './TreeMenu.vue'
export default {
  name: 'TreeMenu',
  props: {
    data: Array,
    mode: {
      type: String,
      default: 'horizontal'
    }
  },
  methods: {
    toggle (event, hasChildren) {
      if (hasChildren) {
        event.preventDefault();
        this.stopPropagation(event)
      }
      if (this.mode === 'vertical') {

        var arrow = event.target.children[0]
        var subMennu = event.target.nextElementSibling.style
        if (subMennu.display === 'block') {
          subMennu.display = 'none'
          arrow.classList.remove('rotate')
        } else {
          arrow.classList.add('rotate')
          subMennu.display = 'block'
        }
      }
    },
    stopPropagation (event) {
      if (event.stopPropagation) {
        event.stopPropagation()
      } else {
        event.cancelBubble = true
      }
    }
  },
  components: {
    TreeMenu
  }
}
</script>

<style scoped lang="scss">
  .TreeMenu.TreeMenu--horizontal {
    list-style:none;
    margin: 0;
    padding: 0;
    position: relative;
    
    li {
      display: inline-block;
      padding: 0;
      position: relative;
      white-space: nowrap;
    }
    li:hover > ul {
      display: block;
    }

    ul {
      background: #fff;
      border-radius: 6px;
      box-shadow: 0 3px 12px 0 rgba(0,0,0,.1);
      position: absolute;
      display: none;
      margin: 0;
      padding: 10px 0;
      left: 50%;
      transform: translateX(-50%);
    }
    ul:before {
      content: "";
      display: block;
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 0 8px 12px 8px;
      border-color: transparent transparent #ffffff transparent;
      position: absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
    }
    ul li {
      color: #333;
      display: block;
      padding: 0;
    }

    ul ul {
      position: absolute;
      top: 0;
      left: 100%;
      transform: translateX(0);
    }
    ul ul:before {
      display: none;
    }
    /*************
    * EXTRA CSS
    *************/
    li a {
      color: inherit;
      padding: 20px 10px;
      display: block;
      text-decoration: none;
      text-transform: uppercase;
    }
    ul li a{
      color: #173345;
      padding: 5px 20px;
      text-transform: none;
    }
    li a:hover {
      color: #36b347;
    }

    ul li a.hasChildren {
      padding: 5px 50px 5px 20px;
    }
    ul li a .arrow {
      width: 8px;
      height: 8px;
      border-width: 1px 1px 0 0;
      border-style: solid;
      margin: 10px;
      transform: rotate(45deg) translateY(-50%);
      position: absolute;
      right: 10px;
      display: inline-block;
      vertical-align: middle;
      color: inherit;
      box-sizing: border-box;
      &:before {
        right: 0;
        top: -3px;
        position: absolute;
        height: 4px;
        box-shadow: inset 0 0 0 32px;
        transform: rotate(-45deg);
        width: 23px;
        transform-origin: right top;
      }
    }
  }

  .TreeMenu.TreeMenu--vertical {
    ul {
      display: none;
    }
    li a {
      display: block;
      font-size: 20px;
      color: #fff;
      line-height: 20px;
      padding: 15px 0;
    }
    li a .arrow {
      width: 8px;
      height: 8px;
      border-width: 1px 1px 0 0;
      border-style: solid;
      margin: 10px;
      transform: rotate(45deg) translateY(-50%);
      position: absolute;
      right: 10px;
      display: inline-block;
      vertical-align: middle;
      color: inherit;
      box-sizing: border-box;
      pointer-events: none;
      &:before {
        right: 0;
        top: -3px;
        position: absolute;
        height: 4px;
        box-shadow: inset 0 0 0 32px;
        transform: rotate(-45deg);
        width: 23px;
        transform-origin: right top;
      }
      transition: transform .2s ease-in-out;
    }
    li a .arrow.rotate {
      transform: rotate(134deg);
    }
    li ul {
      margin-left: 10px;
    }
    li ul ul li a {
      font-size: 16px;
      margin-left: 10px;
    }
  }
</style>

