def romanToInt(self, s):
    s = list(s)
    print(s)


def getPosNums(num):
    posNums = []
    
    while num != 0:
        posNums.append(num % 10)
        num = num // 10
    
    for i in range(len(posNums)):
        value = posNums[i] * (10**i)
        print(value)
            
    # print(posNums)
    return posNums
    
getPosNums(100)



