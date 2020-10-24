.PHONY: test
test: part1 part2
         ./test.sh

part1:
        go build commandCount.go

part2: main.c rectangle.c rectangle.h main.c
        c99 -Wall -Werror main.c rectangle.c -o part2
