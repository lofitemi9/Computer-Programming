while True:
    sentence = input("Type in duplicate words")
    first2char = sentence[0:2]
    print(first2char)
    count = 0

    for i in range(len(sentence) - 1):
        if sentence[i:i+2] == first2char:
            count = count + 1

    print(count)