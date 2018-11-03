<template>
  <div class="GridPlans section">
    <div class="container is-fluid">
      <div class="columns is-multiline">
        <div class="column is-flex is-full-mobile is-half-tablet is-one-quarter-desktop" v-for="plan in structure.information.plans" :key="plan.id">
          <div class="GridPlans-box box">
            <div class="GridPlans-boxBest" v-if="plan.best">
              <div class="GridPlans-boxBestRibbon"></div>
            </div>
            <div class="GridPlans-boxTitle">
              <h2 class="GridPlans-boxTitleText">{{plan.title}}</h2>
              <span class="GridPlans-boxTitlePeriod">{{plan.period}}</span>
            </div>
            
            <div class="GridPlans-price">
              <span class="GridPlans-priceBox">
                <sup class="GridPlans-priceBoxCurrency">USD</sup>
                {{plan.price}}
              </span>
            </div>
            <div v-html="plan.description"></div>
            <div class="GridPlans-boxFooter">
              <a class="button is-success is-medium is-fullwidth is-outlined is-rounded">Comprar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'GridPlans',
  computed: {
    structure () {
      return this.$store.getters.structure
    }
  }
}
</script>

<style scoped lang="scss">
  .GridPlans {
    &-box {
      padding-bottom: 90px;
      position: relative;
    }
    &-boxBest {
      border-radius: 0 6px;
      position: absolute;
      top: 0;
      right: 0;
      width: 62px;
      height: 58px;
      overflow: hidden;
      &:after {
        content: '★';
        position: absolute;
        right: 11px;
        top: 3px;
        color: #fff;
        font-size: 16px;
        z-index: 11;
      }
    }
    &-boxBestRibbon {
      background-color: #36b347;
      height: 50px;
      width: 100px;
      position: absolute;
      top: -12px;
      transform: rotate(43deg);
    }
    &-boxTitle {
      margin-bottom: 20px;
      text-align: center;
    }
    &-boxTitleText {
      color: #10232f;
      font-size: 20px;
      font-weight: bold;
    }
    &-boxTitlePeriod {
      color: #36b347;
      font-size: 12px;
    }
    &-boxFooter {
      position: absolute;
      right: 20px;
      bottom: 20px;
      left: 20px;
    }
    &-price {
      text-align: center;
      margin-bottom: 10px;
    }
    &-priceBox {
      font-size: 66px;
      font-weight: 500;
      color: #10232f;
      position: relative;
      &:after {
        content: "x mes";
        display: block;
        position: absolute;
        bottom: 0;
        font-size: 12px;
        text-align: center;
        left: 50%;
        transform: translateX(-50%);
      }
    }
    &-priceBoxCurrency {
      font-size: 12px;
      position: absolute;
      margin-right: 6px;
      right: 100%;
      top: 50%;
      transform: translateY(-50%);
    }
  }
  .GridPlans {
    /deep/ ul {
      color: #7c7c7c;
      font-size: 14px;
      list-style: disc;
      margin-left: 10px;
    }
    /deep/ ul li {
      margin-bottom: 10px;
    }
    /deep/ ul div {
      font-size: 12px;
      color: #10232f;
    }
  }
</style>
