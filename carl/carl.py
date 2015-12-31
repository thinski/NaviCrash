# encoding: utf-8
import math

speedmath = [0,105,555,1005,2755,5505,13505]   # 个人所得税速算扣除数

income = 16000      # 税前收入
average = 6054       # 本市平均工资
least = 2030         # 本市最低工资

rate = {               # 个人缴纳的各项税率
    'old' : 0.08,      # 养老保险税率
    'medical' : 0.02,  # 医疗保险税率
    'shiye' : 0.01,    # 失业保险税率
    'gjj' : 0.12       # 公积金税率
}


def get_tax(shebao,gjj):
    k = income - shebao - gjj -3500

    tax = 0
    if k <= 1500 and k >= 0:
        tax = k*0.03 - speedmath[0]
    elif k > 1500 and k <= 4500:
        tax = k*0.1 - speedmath[1]
    elif k > 4500 and k <= 9000:
        tax = k*0.2 - speedmath[2]
    elif k > 9000 and k <= 35000:
        tax = k*0.25 - speedmath[3]
    elif k > 35000 and k <= 55000:
        tax = k*0.3 - speedmath[4]
    elif k > 55000 and k <= 80000:
        tax = k*0.35 - speedmath[5]
    elif k > 80000:
        tax = k*0.45 - speedmath[6]
    print '个人所得税：' + str(tax)
    return tax

def get_shebao(income,average,least):
    if income >= average*3:
        income = average*3
    old = income * rate['old']
    medical = income * rate['medical']
    shiye = least * rate['shiye']
    total = old + shiye + medical
    print '社保：' + str(total)
    return total

def get_gjj(income,average):
    if income >= average *5:
        income = average*5
    gjj = income * rate['gjj']
    print '公积金：' + str(gjj)
    return gjj

def main():
    print '税前收入：' + str(income)
    shebao = get_shebao(income,average,least)
    gjj = get_gjj(income,average)
    tax = get_tax(shebao,gjj)
    print '税后收入：' + str(income - shebao - gjj - tax)

if __name__=="__main__":
    main()

