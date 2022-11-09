package main

import (
	"github.com/kulti/titlecase"
	"github.com/stretchr/testify/require"
	//"strings"
	"testing"
)

// Задание
// 1. Дописать существующие тесты.
// 2. Придумать один новый тест.
//
// Дополнительное задание: использовать табличные тесты и testify.require
//
// Документация по тестируемой функции:
// Делает слова в строке из первого аргумента с большой буквы, кроме слов из строки из второго аргумента
// Первое слово всегда с большой буквы
//
// TitleCase(str, minor) returns a str string with all words capitalized except minor words.
// The first word is always capitalized.
//
// E.g.
// TitleCase("the quick fox in the bag", "") = "The Quick Fox In The Bag"
// TitleCase("the quick fox in the bag", "in the") = "The Quick Fox in the Bag"

func TestEmpty(t *testing.T) {
	const str, minor, want = "the quick fox in the bag", "", "The Quick Fox In The Bag"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

// func TestWithoutMinor(t *testing.T) {
// 	const str, want = "", ""
// 	got := titlecase.TitleCase(str, "")
// 	if got != want {
// 		t.Errorf("TitleCase(%v) = %v; want %v", str, got, want)
// 	}
// }

// func TestWithMinorInFirst(t *testing.T) {
// 	const str, want = "the quick fox in the bag", "The Quick Fox In the Bag"
// 	minor := strings.Split(str, " ")[0]
// 	got := titlecase.TitleCase(str, "the")
// 	if got != want {
// 		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
// 	}
// }

func TestTitleCase(t *testing.T) {
	tests := []struct {
		name     string
		str      string
		minor    string
		expected string
	}{
		//Если я правильно понял, то по сути тесты выше проверяют одну функцию, отличаются только данные,
		//поэтому можно все данные завернуть в таблицу и прогонять как один тест
		{"testempty", "", "", ""},
		{"TestWithoutMinor", "the quick brown fox", "", "The Quick Brown Fox"},
		{"TestWithMinorInFirst", "the quick brown fox in the bag", "the", "The Quick Brown Fox In the Bag"},
		{"TestWithReverseCapital", "tHE qUICK bROWN fOX iN tHE bAG", "in of the", "The Quick Brown Fox in the Bag"},
		{"TestWithNumbers", "2bananas", "bananas", "2bananas"},
	}
	for _, tc := range tests {
		t.Run(tc.name, func(t *testing.T) {
			require.Equal(t, tc.expected, titlecase.TitleCase(tc.str, tc.minor))
		})
	}
}
